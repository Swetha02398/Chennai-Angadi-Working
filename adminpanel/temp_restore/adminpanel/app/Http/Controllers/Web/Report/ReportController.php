<?php

namespace App\Http\Controllers\Web\Report;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display the report page
     */
    public function index()
    {
        return view('report.report');
    }

    /**
     * Filter orders based on type, day, month, year
     */
    public function filter(Request $request)
    {
        $orderType = $request->get('order_type', 'all'); // 'frontend', 'billing', 'all'
        $day = $request->get('day');
        $month = $request->get('month');
        $year = $request->get('year');

        $query = Order::with(['customer', 'items']);

        // Filter by order type
        if ($orderType === 'frontend') {
            $query->where('order_type', 'frontend');
        } elseif ($orderType === 'billing') {
            $query->where('order_type', 'billing');
        }

        // Filter by year
        if ($year) {
            $query->whereYear('created_at', $year);
        }

        // Filter by month
        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        // Filter by day
        if ($day) {
            $query->whereDay('created_at', $day);
        }

        // Clone query for summary calculation BEFORE pagination
        $summaryQuery = clone $query;

        $totalOrders = $summaryQuery->count();
        $totalAmount = (float) $summaryQuery->sum('final_amount');
        $paidOrders = (clone $summaryQuery)->whereRaw('LOWER(payment_status) = ?', ['paid'])->count();
        $pendingOrders = (clone $summaryQuery)->whereRaw('LOWER(payment_status) = ?', ['pending'])->count();

        // Apply pagination
        $perPage = 10;
        $orders = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Format the response
        $formattedOrders = collect($orders->items())->map(function ($order) {
            $customerName = 'Guest';
            if ($order->customer_type === 'registered' && $order->customer) {
                $customerName = $order->customer->username ?? $order->customer->name ?? 'N/A';
            } elseif ($order->guest_details) {
                $customerName = $order->guest_details['first_name']
                    ?? $order->guest_details['name']
                    ?? 'Guest';
            }

            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'date' => $order->created_at->format('d M Y H:i'),
                'customer' => $customerName,
                'customer_type' => ucfirst($order->customer_type),
                'order_type' => ucfirst($order->order_type),
                'order_source' => $order->order_source,
                'items_count' => $order->items->count(),
                'amount' => number_format($order->final_amount, 2),
                'payment_method' => \Illuminate\Support\Str::headline($order->payment_method ?? 'N/A'),
                'payment_status' => ucfirst($order->payment_status),
                'status' => ucfirst($order->status),
            ];
        });

        return response()->json([
            'success' => true,
            'orders' => $formattedOrders,
            'summary' => [
                'total_orders' => $totalOrders,
                'total_amount' => number_format($totalAmount, 2),
                'paid_orders' => $paidOrders,
                'pending_orders' => $pendingOrders,
            ],
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'from' => $orders->firstItem(),
                'to' => $orders->lastItem(),
            ]
        ]);
    }

    /**
     * Export orders to Excel (CSV format)
     */
    public function exportExcel(Request $request)
    {
        $orderType = $request->get('order_type', 'all');
        $day = $request->get('day');
        $month = $request->get('month');
        $year = $request->get('year');

        $query = Order::with(['customer', 'items']);

        // Filter by order type
        if ($orderType === 'frontend') {
            $query->where('order_type', 'frontend');
        } elseif ($orderType === 'billing') {
            $query->where('order_type', 'billing');
        }

        // Filter by year
        if ($year) {
            $query->whereYear('created_at', $year);
        }

        // Filter by month
        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        // Filter by day
        if ($day) {
            $query->whereDay('created_at', $day);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        // Create CSV content
        $filename = 'orders_report_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // CSV Header
            fputcsv($file, [
                'Order #',
                'Date',
                'Customer',
                'Customer Type',
                'Order Type',
                'Order Source',
                'Items Count',
                'Amount (₹)',
                'Payment Method',
                'Payment Status',
                'Status'
            ]);

            // CSV Data
            foreach ($orders as $order) {
                $customerName = 'Guest';
                if ($order->customer_type === 'registered' && $order->customer) {
                    $customerName = $order->customer->username ?? $order->customer->name ?? 'N/A';
                } elseif ($order->guest_details) {
                    $customerName = $order->guest_details['first_name']
                        ?? $order->guest_details['name']
                        ?? 'Guest';
                }

                fputcsv($file, [
                    $order->order_number,
                    "\t" . $order->created_at->format('d-m-Y H:i'),
                    $customerName,
                    ucfirst($order->customer_type),
                    ucfirst($order->order_type),
                    \Illuminate\Support\Str::headline($order->order_source ?? 'N/A'),
                    $order->items->count(),
                    number_format($order->final_amount, 2),
                    \Illuminate\Support\Str::headline($order->payment_method ?? 'N/A'),
                    ucfirst($order->payment_status),
                    ucfirst($order->status)
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
