@extends('layouts.app')
@section('content')

<section class="content-main">
    @include('includes.alert')
    <div class="content-header">
        <h2 class="content-title">{{ isset($rule) ? 'Edit Rule' : 'Add Rule' }}</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="shippingRuleForm" method="POST" action="{{ isset($rule) ? route('shipping.rules.update', $rule->id) : route('shipping.rules.store') }}" novalidate>
                @csrf
                @if(isset($rule))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Shipping Zone</label>
                    <select name="shipping_zone_id" id="shippingZone" class="form-select" required>
                        <option value="">-- Select Zone --</option>
                        @foreach($zones as $z)
                            <option value="{{ $z->id }}" {{ (isset($rule) && $rule->shipping_zone_id == $z->id) ? 'selected' : '' }}>
                                {{ $z->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">State</label>
                    <select name="states[]" id="statesSelect" class="form-select" multiple required>
                        @foreach($states as $s)
                            <option value="{{ $s->state }}"
                                {{ isset($rule) && in_array($s->state, $rule->states ?? []) ? 'selected':'' }}>
                                {{ $s->state }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Hold Ctrl / Cmd to select multiple</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Condition Type</label>
                    <select name="condition_type" class="form-select" required>
                        <option value="">-- Select Condition Type --</option>
                        <option value="weight" {{ (isset($rule) && $rule->condition_type=='weight') ? 'selected' : '' }}>Weight</option>
                        <option value="final_amount" {{ (isset($rule) && $rule->condition_type=='final_amount') ? 'selected' : '' }}>Final Amount</option>
                    </select>
                </div>

                <h5 class="mb-3">Shipping Slabs</h5>

                <table class="table table-bordered" id="slabsTable">
                    <thead class="table-light">
                        <tr>
                            <th>Min (₹)</th>
                            <th>Max (₹)</th>
                            <th>Amount (₹)</th>
                            <th width="80">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $slabs = old('slabs', isset($rule)?$rule->slabs:[]);
                        @endphp

                        @forelse($slabs as $i => $slab)
                        <tr class="slab-row">
                            <td>
                                <input type="number" name="slabs[{{$i}}][min]"
                                       class="form-control"
                                       value="{{ $slab['min'] ?? $slab->min_slab }}" required>
                            </td>
                            <td>
                                <input type="number" name="slabs[{{$i}}][max]"
                                       class="form-control"
                                       value="{{ $slab['max'] ?? $slab->max_slab }}" required>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" name="slabs[{{$i}}][amount]"
                                           class="form-control"
                                           value="{{ $slab['amount'] ?? $slab->shipping_amount }}" required>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($i == 0)
                                    <button type="button" class="btn btn-success add" style="width: 95px; height: 34px; border-radius: 6px; padding: 0; font-size: 13px;"><i class="bi bi-plus-circle me-1"></i> Add</button>
                                @else
                                    <button type="button" class="btn btn-danger remove" style="width: 95px; height: 34px; border-radius: 6px; padding: 0; font-size: 13px;"><i class="bi bi-dash-circle me-1"></i> Remove</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr class="slab-row">
                            <td><input type="number" name="slabs[0][min]" class="form-control" required></td>
                            <td><input type="number" name="slabs[0][max]" class="form-control" required></td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" name="slabs[0][amount]" class="form-control" required>
                                </div>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-success add" style="width: 95px; height: 34px; border-radius: 6px; padding: 0; font-size: 13px;"><i class="bi bi-plus-circle me-1"></i> Add</button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> {{ isset($rule) ? 'Update' : 'Save' }}</button>
                    <a href="{{ route('shipping.rules.table') }}" class="btn btn-secondary"><i class="bi bi-arrow-left-circle me-1"></i> Back</a>
                </div>
            </form>
        </div>
    </div>
<script>
let index = document.querySelectorAll('.slab-row').length;
const shippingZone = document.getElementById('shippingZone');
const statesSelect = document.getElementById('statesSelect');

// Update units based on condition type
function updateUnits() {
    const conditionType = document.querySelector('select[name="condition_type"]').value;
    const headers = document.querySelectorAll('#slabsTable thead th');
    if (conditionType === 'weight') {
        headers[0].innerHTML = 'Min (g)';
        headers[1].innerHTML = 'Max (g)';
    } else {
        headers[0].innerHTML = 'Min (₹)';
        headers[1].innerHTML = 'Max (₹)';
    }
}

// Fetch and load states dynamically
function loadStates(zoneId, selectedStates = []) {
    if (!zoneId) {
        statesSelect.innerHTML = '';
        return;
    }
    const url = "{{ route('shipping.get-states-by-zone', ':zone_id') }}".replace(':zone_id', zoneId);
    
    fetch(url)
        .then(res => res.json())
        .then(data => {
            statesSelect.innerHTML = '';
            data.forEach(state => {
                const opt = document.createElement('option');
                opt.value = state;
                opt.textContent = state;
                if (selectedStates.includes(state)) {
                    opt.selected = true;
                }
                statesSelect.appendChild(opt);
            });
        })
        .catch(err => console.error('Error fetching states:', err));
}

// Add/Remove slab rows
document.addEventListener('click', function(e) {
    // Add new slab row
    if (e.target.classList.contains('add')) {
        let row = e.target.closest('.slab-row');
        let clone = row.cloneNode(true);
        
        clone.querySelectorAll('input').forEach(inp => {
            inp.name = inp.name.replace(/\d+/, index);
            inp.value = '';
        });
        
        let btn = clone.querySelector('.add') || clone.querySelector('.remove');
        if(btn) {
            btn.className = 'btn btn-danger remove';
            btn.style.cssText = 'width: 95px; height: 34px; border-radius: 6px; padding: 0; font-size: 13px;';
            btn.innerText = '- Remove';
        }
        
        index++;
        document.querySelector('#slabsTable tbody').appendChild(clone);
    }
    
    // Remove slab row
    if (e.target.classList.contains('remove')) {
        let rows = document.querySelectorAll('.slab-row');
        if (rows.length > 1) {
            e.target.closest('.slab-row').remove();
        } else {
            alert('At least one slab is required');
        }
    }
});

// Listen for condition type change
document.querySelector('select[name="condition_type"]').addEventListener('change', updateUnits);

// Listen for shipping zone change
shippingZone.addEventListener('change', function() {
    const zoneId = this.value.trim();
    if (zoneId) {
        this.classList.remove('is-invalid');
        loadStates(zoneId);
    } else {
        statesSelect.innerHTML = '';
    }
});

statesSelect.addEventListener('change', function() {
    if (this.selectedOptions.length > 0) {
        this.classList.remove('is-invalid');
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateUnits();
    
    const initialZone = shippingZone.value.trim();
    const selectedStates = @json(old('states', $rule->states ?? []));
    if (initialZone) {
        loadStates(initialZone, selectedStates);
    }
});

document.getElementById('shippingRuleForm').addEventListener('submit', function (e) {
    let valid = true;
    const zone = this.querySelector('select[name="shipping_zone_id"]');
    const states = this.querySelector('select[name="states[]"]');
    const condition = this.querySelector('select[name="condition_type"]');

    if (!zone.value) {
        zone.classList.add('is-invalid');
        valid = false;
    } else {
        zone.classList.remove('is-invalid');
    }

    if (states.selectedOptions.length === 0) {
        states.classList.add('is-invalid');
        valid = false;
    } else {
        states.classList.remove('is-invalid');
    }

    if (!condition.value) {
        condition.classList.add('is-invalid');
        valid = false;
    } else {
        condition.classList.remove('is-invalid');
    }

    // Slabs validation
    const slabInputs = this.querySelectorAll('.slab-row input[required]');
    slabInputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            valid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    if (!valid) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: "smooth" });
    }
});
</script>
</section>

@endsection