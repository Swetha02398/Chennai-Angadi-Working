@extends('layouts.app')
@section('content')

{{-- ---------- FORM SECTION ---------- --}}
<section class="content-main">
    @include('includes.alert')
<div class="content-header">
    <h2 class="shipping-title">
        {{ isset($rule) ? 'Edit Shipping Rule' : 'Add Shipping Rule' }}
    </h2>
</div>

<div class="card">
<div class="card-body">

<form method="POST"
      action="{{ isset($rule) ? route('shipping.rules.update',$rule->id) : route('shipping.rules.store') }}"
      id="rulesForm" novalidate>
@csrf
@if(isset($rule)) @method('PUT') @endif

{{-- SHIPPING ZONE --}}
<div class="mb-3">
<label class="form-label fw-bold">Shipping Zone</label>
<select name="shipping_zone_id" id="shippingZone" class="form-select" required>
    <option value="">-- Select Zone --</option>
    @foreach($zones as $z)
        <option value="{{ $z->id }}"
            {{ old('shipping_zone_id',$rule->shipping_zone_id ?? '')==$z->id?'selected':'' }}>
            {{ $z->name }}
        </option>
    @endforeach
</select>
<small class="text-danger d-none" id="zoneError">Zone selection cannot be empty.</small>
</div>

{{-- STATES --}}
<div class="mb-3">
<label class="form-label fw-bold">State</label>
<select name="states[]" id="statesSelect" class="form-select" multiple required>
    @foreach($states as $s)
        <option value="{{ $s->state }}"
            {{ isset($rule) && in_array($s->state, $rule->states ?? []) ? 'selected':'' }}>
            {{ $s->state }}
        </option>
    @endforeach
</select>
<small class="text-muted-small">Hold Ctrl / Cmd to select multiple</small>
<small class="text-danger d-none" id="statesError">Please select at least one state.</small>
</div>

{{-- CONDITION TYPE --}}
<div class="mb-3">
<label class="form-label fw-bold">Condition Type</label>
<select name="condition_type" id="conditionType" class="form-select" required>
    <option value="">-- Select --</option>
    <option value="weight"
        {{ old('condition_type',$rule->condition_type ?? '')=='weight'?'selected':'' }}>
        Weight
    </option>
    <option value="final_amount"
        {{ old('condition_type',$rule->condition_type ?? '')=='final_amount'?'selected':'' }}>
        Final Amount
    </option>
</select>
<small class="text-danger d-none" id="conditionError">Condition type cannot be empty.</small>
</div>


{{-- SLABS --}}
<h5 class="mb-3">Shipping Slabs</h5>

<table class="table table-bordered" id="slabsTable">
<thead class="table-light">
<tr>
    <th>Min (<span id="unitMin">₹</span>)</th>
    <th>Max (<span id="unitMax">₹</span>)</th>
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
               class="form-control slab-min"
               value="{{ $slab['min'] ?? $slab->min_slab }}" required>
    </td>
    <td>
        <input type="number" name="slabs[{{$i}}][max]"
               class="form-control slab-max"
               value="{{ $slab['max'] ?? $slab->max_slab }}" required>
    </td>
    <td>
        <div class="input-group">
            <span class="input-group-text">₹</span>
            <input type="number" name="slabs[{{$i}}][amount]"
                   class="form-control slab-amount"
                   value="{{ $slab['amount'] ?? $slab->shipping_amount }}" required>
        </div>
    </td>
    <td class="text-center">
        @if($i == 0)
            <button type="button" class="btn btn-success add" style="width: 95px; height: 34px; border-radius: 6px; padding: 0; font-size: 13px;">+ Add</button>
        @else
            <button type="button" class="btn btn-danger remove" style="width: 95px; height: 34px; border-radius: 6px; padding: 0; font-size: 13px;">- Remove</button>
        @endif
    </td>
</tr>
@empty
<tr class="slab-row">
    <td><input type="number" name="slabs[0][min]" class="form-control slab-min" required></td>
    <td><input type="number" name="slabs[0][max]" class="form-control slab-max" required></td>
    <td>
        <div class="input-group">
            <span class="input-group-text">₹</span>
            <input type="number" name="slabs[0][amount]" class="form-control slab-amount" required>
        </div>
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-success add" style="width: 95px; height: 34px; border-radius: 6px; padding: 0; font-size: 13px;">+ Add</button>
    </td>
</tr>
@endforelse

</tbody>
</table>
<small class="text-danger d-none" id="slabsError">Please fill in all slab fields with valid values.</small>

<div class="mt-4">
<button class="btn btn-primary" id="submitBtn">{{ isset($rule)?'Update':'Save' }}</button>
<a href="{{ route('shipping.rules.table') }}" class="btn btn-secondary">Back</a>
</div>

</form>
</div>
</div>
</section>

{{-- ---------- JS LOGIC ---------- --}}
<script>
let index = document.querySelectorAll('.slab-row').length;
const conditionType = document.getElementById('conditionType');
const unitMin = document.getElementById('unitMin');
const unitMax = document.getElementById('unitMax');
const rulesForm = document.getElementById('rulesForm');
const shippingZone = document.getElementById('shippingZone');
const statesSelect = document.getElementById('statesSelect');
const zoneError = document.getElementById('zoneError');
const statesError = document.getElementById('statesError');
const conditionError = document.getElementById('conditionError');
const slabsError = document.getElementById('slabsError');

function updateUnits(){
    if(conditionType.value === 'weight'){
        unitMin.innerText = 'g';
        unitMax.innerText = 'g';
    }else{
        unitMin.innerText = '₹';
        unitMax.innerText = '₹';
    }
}

function validateSlabs() {
    const slabRows = document.querySelectorAll('.slab-row');
    let isValid = true;
    
    slabRows.forEach(row => {
        const minInput = row.querySelector('.slab-min');
        const maxInput = row.querySelector('.slab-max');
        const amountInput = row.querySelector('.slab-amount');
        
        const min = minInput.value.trim();
        const max = maxInput.value.trim();
        const amount = amountInput.value.trim();
        
        if (!min || !max || !amount) {
            isValid = false;
            if(!min) minInput.classList.add('is-invalid');
            if(!max) maxInput.classList.add('is-invalid');
            if(!amount) amountInput.classList.add('is-invalid');
        } else {
            minInput.classList.remove('is-invalid');
            maxInput.classList.remove('is-invalid');
            amountInput.classList.remove('is-invalid');
        }
    });
    
    return isValid;
}

function validateForm() {
    let isValid = true;
    
    // Validate zone
    if (!shippingZone.value.trim()) {
        zoneError.classList.remove('d-none');
        shippingZone.classList.add('is-invalid');
        isValid = false;
    } else {
        zoneError.classList.add('d-none');
        shippingZone.classList.remove('is-invalid');
    }
    
    // Validate states
    const selectedStates = Array.from(statesSelect.selectedOptions).length;
    if (selectedStates === 0) {
        statesError.classList.remove('d-none');
        statesSelect.classList.add('is-invalid');
        isValid = false;
    } else {
        statesError.classList.add('d-none');
        statesSelect.classList.remove('is-invalid');
    }
    
    // Validate condition type
    if (!conditionType.value.trim()) {
        conditionError.classList.remove('d-none');
        conditionType.classList.add('is-invalid');
        isValid = false;
    } else {
        conditionError.classList.add('d-none');
        conditionType.classList.remove('is-invalid');
    }
    
    // Validate slabs
    if (!validateSlabs()) {
        slabsError.classList.remove('d-none');
        // Slab inputs are handled in validateSlabs()
        isValid = false;
    } else {
        slabsError.classList.add('d-none');
    }
    
    return isValid;
}

rulesForm.addEventListener('submit', function(e) {
    e.preventDefault();
    if (validateForm()) {
        rulesForm.submit();
    }
});

document.addEventListener('click', function(e){

    if(e.target.classList.contains('add')){
        let row = e.target.closest('.slab-row');
        let clone = row.cloneNode(true);

        clone.querySelectorAll('input').forEach(inp=>{
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

    if(e.target.classList.contains('remove')){
        let rows = document.querySelectorAll('.slab-row');
        if(rows.length > 1){
            e.target.closest('.slab-row').remove();
        }
    }

});

conditionType.addEventListener('change', updateUnits);

const oldStates = @json(old('states', []));

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

shippingZone.addEventListener('change', function() {
    const zoneId = this.value.trim();
    if (zoneId) {
        zoneError.classList.add('d-none');
        loadStates(zoneId);
    } else {
        statesSelect.innerHTML = '';
        zoneError.classList.remove('d-none');
    }
});

statesSelect.addEventListener('change', function() {
    if (this.selectedOptions.length > 0) statesError.classList.add('d-none');
});

document.addEventListener('DOMContentLoaded', function() {
    updateUnits();
    const zoneId = shippingZone.value.trim();
    if (zoneId) {
        loadStates(zoneId, oldStates);
    }
});
</script>

@endsection