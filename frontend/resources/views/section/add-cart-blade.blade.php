@extends('layouts.app')
@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('index') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span>
                    <a href="{{ route('shop') }}">Shop</a>

                    <span></span> Cart
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h1 class="heading-2 mb-10">Your Cart</h1>
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body">There are <span class="text-brand">{{ $cartItems->count() }}</span> products
                            in your cart</h6>
                        <h6 class="text-body"><a href="#" class="text-muted" onclick="clearCart(); return false;"><i
                                    class="fi-rs-trash mr-5"></i>Clear Cart</a></h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <!-- Desktop Table View -->
                    <div class="table-responsive shopping-summery d-none d-md-block">
                        <table class="table table-wishlist">
                            <thead>
                                <tr class="main-heading">
                                    <th class="custome-checkbox start pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="selectAll"
                                            value="">
                                        <label class="form-check-label" for="selectAll"></label>
                                    </th>
                                    <th scope="col" colspan="2">Product</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col" class="end">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cartItems as $item)
                                    <tr class="pt-30">
                                        <td class="custome-checkbox pl-30">
                                            <input class="form-check-input" type="checkbox" name="checkbox"
                                                value="{{ $item->id }}">
                                            <label class="form-check-label"></label>
                                        </td>
                                        <td class="image product-thumbnail pt-40">
                                            @php
                                                // productimage is already cast as array in the Product model
                                                $images = $item->product->productimage;

                                                // Ensure it's an array and get the first image
                                                if (is_array($images) && count($images) > 0) {
                                                    $primaryImage = $images[0];
                                                } else {
                                                    $primaryImage = null;
                                                }
                                                if ($primaryImage) {
                                                    $primaryImage = str_replace('\\', '/', $primaryImage);
                                                    $primaryImage = basename($primaryImage);
                                                }
                                            @endphp
                                            <img src="{{ env('ADMIN_ASSET_URL') }}/products/{{ $primaryImage }}" width="100"
                                                height="100" alt="{{ $item->product->productname }}"
                                                onerror="this.src='{{ asset('assets/imgs/theme/icons/category-1.svg') }}'">
                                        </td>
                                        <td class="product-des product-name">
                                            <h6 class="mb-5">
                                                <a class="product-name mb-10 text-heading"
                                                    href="{{ route('product.details', $item->product->slug) }}">
                                                    {{ $item->product->productname }}
                                                </a>
                                            </h6>

                                            @php
                                                // Get the weight from the cart item if stored, otherwise look up by variant_id
                                                $weightName = null;
                                                if (isset($item->selected_weight) && $item->selected_weight) {
                                                    $weightName = $item->selected_weight;
                                                } elseif (isset($item->variant_id) && $item->variant_id) {
                                                    $cartVariant = $item->product->variants()->with('quantity')->where('id', $item->variant_id)->first();
                                                    $weightName = $cartVariant && $cartVariant->quantity ? ($cartVariant->quantity->name ?? $cartVariant->quantity->label) : null;
                                                }
                                            @endphp

                                            @if($weightName)
                                                <span style="color: #3BB77E; font-size: 13px; font-weight: 500;"
                                                    class="d-block mb-5">{{ $weightName }}</span>
                                            @endif



                                            <!-- @php
                                                                                                // Fetch approved reviews for this product
                                                                                                $reviews = $item->product->reviews->where('approved', true);

                                                                                                $avgRating = $reviews->count() ? round($reviews->avg('rating'), 1) : 0;
                                                                                                $avgRatingPercent = $avgRating / 5 * 100;
                                                                                            @endphp

                                                                                            <div class="product-rate-cover">
                                                                                                <div class="product-rate d-inline-block">
                                                                                                    <div class="product-rating" style="width: {{ $avgRatingPercent }}%"></div>
                                                                                                </div>
                                                                                                <span class="font-small ml-5 text-muted">({{ $avgRating ?: '0.0' }})</span>
                                                                                            </div> -->
                                        </td>


                                        <td class="price" data-title="Price">
                                            <h4 class="text-body">₹{{ $item->price_at_add_time }}</h4>
                                        </td>
                                        <td class="text-center detail-info" data-title="Stock">
                                            <div class="detail-extralink mr-15">
                                                <div class="detail-qty border radius">
                                                    <a href="#" class="qty-down"><i
                                                            class="fi-rs-angle-small-down"></i></a>
                                                    <input type="text" name="quantity" class="qty-val"
                                                        value="{{ $item->quantity }}" min="1" data-item-id="{{ $item->id }}"
                                                        onchange="updateCartQuantity(this, '{{ $item->id }}')">
                                                    <a href="#" class="qty-up"><i
                                                            class="fi-rs-angle-small-up"></i></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="price" data-title="Subtotal">
                                            <h4 class="text-brand subtotal-{{ $item->id }}">
                                                ₹{{ $item->price_at_add_time * $item->quantity }}</h4>
                                        </td>
                                        <td class="action text-center" data-title="Remove">
                                            <a href="#" class="text-body"
                                                onclick="removeFromCart('{{ $item->id }}'); return false;">
                                                <i class="fi-rs-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <h5 class="text-muted">Your cart is empty</h5>
                                            <a href="{{ route('index') }}" class="btn btn-sm mt-3">Continue Shopping</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="mobile-cart-items d-md-none">
                        @foreach($cartItems as $item)
                            @php
                                $images = $item->product->productimage;
                                $primaryImage = (is_array($images) && count($images) > 0) ? $images[0] : null;
                                if ($primaryImage) {
                                    $primaryImage = str_replace('\\', '/', basename($primaryImage));
                                }
                                
                                $weightName = null;
                                if (isset($item->selected_weight) && $item->selected_weight) {
                                    $weightName = $item->selected_weight;
                                } elseif (isset($item->variant_id) && $item->variant_id) {
                                    $cartVariant = $item->product->variants()->with('quantity')->where('id', $item->variant_id)->first();
                                    $weightName = $cartVariant && $cartVariant->quantity ? ($cartVariant->quantity->name ?? $cartVariant->quantity->label) : null;
                                }
                            @endphp
                            <div class="cart-card mb-3 p-2">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="product-img-mobile mr-15">
                                        <img src="{{ env('ADMIN_ASSET_URL') }}/products/{{ $primaryImage }}" 
                                            alt="{{ $item->product->productname }}"
                                            style="width: 70px; height: 70px; border-radius: 10px; object-fit: cover;"
                                            onerror="this.src='{{ asset('assets/imgs/theme/icons/category-1.svg') }}'">
                                    </div>
                                    <div class="product-info-mobile flex-grow-1">
                                        <h6 class="product-name mb-0" style="font-size: 16px; color: #253D4E;">{{ $item->product->productname }}</h6>
                                        @if($weightName)
                                            <span class="text-muted font-sm">{{ $weightName }}</span>
                                        @endif
                                    </div>
                                    <div class="product-remove-mobile">
                                        <a href="#" class="text-muted" onclick="removeFromCart('{{ $item->id }}'); return false;">
                                            <i class="fi-rs-trash" style="font-size: 18px;"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="product-price-mobile">
                                        <h4 class="text-body mb-0 subtotal-{{ $item->id }}" style="font-weight: 700;">₹{{ $item->price_at_add_time * $item->quantity }}</h4>
                                    </div>
                                    <div class="detail-qty mobile-qty-compact border radius d-flex align-items-center">
                                        <input type="text" name="quantity" class="qty-val" value="{{ $item->quantity }}" readonly 
                                            data-item-id="{{ $item->id }}"
                                            style="width: 30px; border: none; background: transparent; text-align: center; font-weight: 700; color: #253D4E; padding: 0;">
                                        <a href="#" class="qty-up">
                                            <i class="fi-rs-angle-small-up"></i>
                                        </a>
                                        <a href="#" class="qty-down">
                                            <i class="fi-rs-angle-small-down"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="divider-2"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="divider-2 mb-30"></div>
                    <div class="cart-action d-flex justify-content-between mb-4">
                        {{-- Desktop: small button (auto width) --}}
                        <a href="{{ route('index') }}" class="btn d-none d-md-inline-flex align-items-center">
                            <i class="fi-rs-arrow-left mr-10"></i>Continue Shopping
                        </a>
                        {{-- Mobile: full-width button --}}
                        <a href="{{ route('index') }}" class="btn w-100 d-md-none">
                            <i class="fi-rs-arrow-left mr-10"></i>Continue Shopping
                        </a>
                    </div>
                    <!-- <div class="row mt-50">
                                                    <div class="col-lg-7">
                                                        <div class="calculate-shiping p-40 border-radius-15 border">
                                                            <h4 class="mb-10">Calculate Shipping</h4>
                                                            <p class="mb-30"><span class="font-lg text-muted">Flat rate:</span><strong class="text-brand">5%</strong></p>
                                                            <form class="field_form shipping_calculator">
                                                                <div class="form-row">
                                                                    <div class="form-group col-lg-12">
                                                                        <div class="custom_select">
                                                                            <select class="form-control select-active w-100">
                                                                                <option value="">United Kingdom</option>
                                                                                <option value="AX">Aland Islands</option>
                                                                                <option value="AF">Afghanistan</option>
                                                                                <option value="AL">Albania</option>
                                                                                <option value="DZ">Algeria</option>
                                                                                <option value="AD">Andorra</option>
                                                                                <option value="AO">Angola</option>
                                                                                <option value="AI">Anguilla</option>
                                                                                <option value="AQ">Antarctica</option>
                                                                                <option value="AG">Antigua and Barbuda</option>
                                                                                <option value="AR">Argentina</option>
                                                                                <option value="AM">Armenia</option>
                                                                                <option value="AW">Aruba</option>
                                                                                <option value="AU">Australia</option>
                                                                                <option value="AT">Austria</option>
                                                                                <option value="AZ">Azerbaijan</option>
                                                                                <option value="BS">Bahamas</option>
                                                                                <option value="BH">Bahrain</option>
                                                                                <option value="BD">Bangladesh</option>
                                                                                <option value="BB">Barbados</option>
                                                                                <option value="BY">Belarus</option>
                                                                                <option value="PW">Belau</option>
                                                                                <option value="BE">Belgium</option>
                                                                                <option value="BZ">Belize</option>
                                                                                <option value="BJ">Benin</option>
                                                                                <option value="BM">Bermuda</option>
                                                                                <option value="BT">Bhutan</option>
                                                                                <option value="BO">Bolivia</option>
                                                                                <option value="BQ">Bonaire, Saint Eustatius and Saba</option>
                                                                                <option value="BA">Bosnia and Herzegovina</option>
                                                                                <option value="BW">Botswana</option>
                                                                                <option value="BV">Bouvet Island</option>
                                                                                <option value="BR">Brazil</option>
                                                                                <option value="IO">British Indian Ocean Territory</option>
                                                                                <option value="VG">British Virgin Islands</option>
                                                                                <option value="BN">Brunei</option>
                                                                                <option value="BG">Bulgaria</option>
                                                                                <option value="BF">Burkina Faso</option>
                                                                                <option value="BI">Burundi</option>
                                                                                <option value="KH">Cambodia</option>
                                                                                <option value="CM">Cameroon</option>
                                                                                <option value="CA">Canada</option>
                                                                                <option value="CV">Cape Verde</option>
                                                                                <option value="KY">Cayman Islands</option>
                                                                                <option value="CF">Central African Republic</option>
                                                                                <option value="TD">Chad</option>
                                                                                <option value="CL">Chile</option>
                                                                                <option value="CN">China</option>
                                                                                <option value="CX">Christmas Island</option>
                                                                                <option value="CC">Cocos (Keeling) Islands</option>
                                                                                <option value="CO">Colombia</option>
                                                                                <option value="KM">Comoros</option>
                                                                                <option value="CG">Congo (Brazzaville)</option>
                                                                                <option value="CD">Congo (Kinshasa)</option>
                                                                                <option value="CK">Cook Islands</option>
                                                                                <option value="CR">Costa Rica</option>
                                                                                <option value="HR">Croatia</option>
                                                                                <option value="CU">Cuba</option>
                                                                                <option value="CW">CuraÇao</option>
                                                                                <option value="CY">Cyprus</option>
                                                                                <option value="CZ">Czech Republic</option>
                                                                                <option value="DK">Denmark</option>
                                                                                <option value="DJ">Djibouti</option>
                                                                                <option value="DM">Dominica</option>
                                                                                <option value="DO">Dominican Republic</option>
                                                                                <option value="EC">Ecuador</option>
                                                                                <option value="EG">Egypt</option>
                                                                                <option value="SV">El Salvador</option>
                                                                                <option value="GQ">Equatorial Guinea</option>
                                                                                <option value="ER">Eritrea</option>
                                                                                <option value="EE">Estonia</option>
                                                                                <option value="ET">Ethiopia</option>
                                                                                <option value="FK">Falkland Islands</option>
                                                                                <option value="FO">Faroe Islands</option>
                                                                                <option value="FJ">Fiji</option>
                                                                                <option value="FI">Finland</option>
                                                                                <option value="FR">France</option>
                                                                                <option value="GF">French Guiana</option>
                                                                                <option value="PF">French Polynesia</option>
                                                                                <option value="TF">French Southern Territories</option>
                                                                                <option value="GA">Gabon</option>
                                                                                <option value="GM">Gambia</option>
                                                                                <option value="GE">Georgia</option>
                                                                                <option value="DE">Germany</option>
                                                                                <option value="GH">Ghana</option>
                                                                                <option value="GI">Gibraltar</option>
                                                                                <option value="GR">Greece</option>
                                                                                <option value="GL">Greenland</option>
                                                                                <option value="GD">Grenada</option>
                                                                                <option value="GP">Guadeloupe</option>
                                                                                <option value="GT">Guatemala</option>
                                                                                <option value="GG">Guernsey</option>
                                                                                <option value="GN">Guinea</option>
                                                                                <option value="GW">Guinea-Bissau</option>
                                                                                <option value="GY">Guyana</option>
                                                                                <option value="HT">Haiti</option>
                                                                                <option value="HM">Heard Island and McDonald Islands</option>
                                                                                <option value="HN">Honduras</option>
                                                                                <option value="HK">Hong Kong</option>
                                                                                <option value="HU">Hungary</option>
                                                                                <option value="IS">Iceland</option>
                                                                                <option value="IN">India</option>
                                                                                <option value="ID">Indonesia</option>
                                                                                <option value="IR">Iran</option>
                                                                                <option value="IQ">Iraq</option>
                                                                                <option value="IM">Isle of Man</option>
                                                                                <option value="IL">Israel</option>
                                                                                <option value="IT">Italy</option>
                                                                                <option value="CI">Ivory Coast</option>
                                                                                <option value="JM">Jamaica</option>
                                                                                <option value="JP">Japan</option>
                                                                                <option value="JE">Jersey</option>
                                                                                <option value="JO">Jordan</option>
                                                                                <option value="KZ">Kazakhstan</option>
                                                                                <option value="KE">Kenya</option>
                                                                                <option value="KI">Kiribati</option>
                                                                                <option value="KW">Kuwait</option>
                                                                                <option value="KG">Kyrgyzstan</option>
                                                                                <option value="LA">Laos</option>
                                                                                <option value="LV">Latvia</option>
                                                                                <option value="LB">Lebanon</option>
                                                                                <option value="LS">Lesotho</option>
                                                                                <option value="LR">Liberia</option>
                                                                                <option value="LY">Libya</option>
                                                                                <option value="LI">Liechtenstein</option>
                                                                                <option value="LT">Lithuania</option>
                                                                                <option value="LU">Luxembourg</option>
                                                                                <option value="MO">Macao S.A.R., China</option>
                                                                                <option value="MK">Macedonia</option>
                                                                                <option value="MG">Madagascar</option>
                                                                                <option value="MW">Malawi</option>
                                                                                <option value="MY">Malaysia</option>
                                                                                <option value="MV">Maldives</option>
                                                                                <option value="ML">Mali</option>
                                                                                <option value="MT">Malta</option>
                                                                                <option value="MH">Marshall Islands</option>
                                                                                <option value="MQ">Martinique</option>
                                                                                <option value="MR">Mauritania</option>
                                                                                <option value="MU">Mauritius</option>
                                                                                <option value="YT">Mayotte</option>
                                                                                <option value="MX">Mexico</option>
                                                                                <option value="FM">Micronesia</option>
                                                                                <option value="MD">Moldova</option>
                                                                                <option value="MC">Monaco</option>
                                                                                <option value="MN">Mongolia</option>
                                                                                <option value="ME">Montenegro</option>
                                                                                <option value="MS">Montserrat</option>
                                                                                <option value="MA">Morocco</option>
                                                                                <option value="MZ">Mozambique</option>
                                                                                <option value="MM">Myanmar</option>
                                                                                <option value="NA">Namibia</option>
                                                                                <option value="NR">Nauru</option>
                                                                                <option value="NP">Nepal</option>
                                                                                <option value="NL">Netherlands</option>
                                                                                <option value="AN">Netherlands Antilles</option>
                                                                                <option value="NC">New Caledonia</option>
                                                                                <option value="NZ">New Zealand</option>
                                                                                <option value="NI">Nicaragua</option>
                                                                                <option value="NE">Niger</option>
                                                                                <option value="NG">Nigeria</option>
                                                                                <option value="NU">Niue</option>
                                                                                <option value="NF">Norfolk Island</option>
                                                                                <option value="KP">North Korea</option>
                                                                                <option value="NO">Norway</option>
                                                                                <option value="OM">Oman</option>
                                                                                <option value="PK">Pakistan</option>
                                                                                <option value="PS">Palestinian Territory</option>
                                                                                <option value="PA">Panama</option>
                                                                                <option value="PG">Papua New Guinea</option>
                                                                                <option value="PY">Paraguay</option>
                                                                                <option value="PE">Peru</option>
                                                                                <option value="PH">Philippines</option>
                                                                                <option value="PN">Pitcairn</option>
                                                                                <option value="PL">Poland</option>
                                                                                <option value="PT">Portugal</option>
                                                                                <option value="QA">Qatar</option>
                                                                                <option value="IE">Republic of Ireland</option>
                                                                                <option value="RE">Reunion</option>
                                                                                <option value="RO">Romania</option>
                                                                                <option value="RU">Russia</option>
                                                                                <option value="RW">Rwanda</option>
                                                                                <option value="ST">São Tomé and Príncipe</option>
                                                                                <option value="BL">Saint Barthélemy</option>
                                                                                <option value="SH">Saint Helena</option>
                                                                                <option value="KN">Saint Kitts and Nevis</option>
                                                                                <option value="LC">Saint Lucia</option>
                                                                                <option value="SX">Saint Martin (Dutch part)</option>
                                                                                <option value="MF">Saint Martin (French part)</option>
                                                                                <option value="PM">Saint Pierre and Miquelon</option>
                                                                                <option value="VC">Saint Vincent and the Grenadines</option>
                                                                                <option value="SM">San Marino</option>
                                                                                <option value="SA">Saudi Arabia</option>
                                                                                <option value="SN">Senegal</option>
                                                                                <option value="RS">Serbia</option>
                                                                                <option value="SC">Seychelles</option>
                                                                                <option value="SL">Sierra Leone</option>
                                                                                <option value="SG">Singapore</option>
                                                                                <option value="SK">Slovakia</option>
                                                                                <option value="SI">Slovenia</option>
                                                                                <option value="SB">Solomon Islands</option>
                                                                                <option value="SO">Somalia</option>
                                                                                <option value="ZA">South Africa</option>
                                                                                <option value="GS">South Georgia/Sandwich Islands</option>
                                                                                <option value="KR">South Korea</option>
                                                                                <option value="SS">South Sudan</option>
                                                                                <option value="ES">Spain</option>
                                                                                <option value="LK">Sri Lanka</option>
                                                                                <option value="SD">Sudan</option>
                                                                                <option value="SR">Suriname</option>
                                                                                <option value="SJ">Svalbard and Jan Mayen</option>
                                                                                <option value="SZ">Swaziland</option>
                                                                                <option value="SE">Sweden</option>
                                                                                <option value="CH">Switzerland</option>
                                                                                <option value="SY">Syria</option>
                                                                                <option value="TW">Taiwan</option>
                                                                                <option value="TJ">Tajikistan</option>
                                                                                <option value="TZ">Tanzania</option>
                                                                                <option value="TH">Thailand</option>
                                                                                <option value="TL">Timor-Leste</option>
                                                                                <option value="TG">Togo</option>
                                                                                <option value="TK">Tokelau</option>
                                                                                <option value="TO">Tonga</option>
                                                                                <option value="TT">Trinidad and Tobago</option>
                                                                                <option value="TN">Tunisia</option>
                                                                                <option value="TR">Turkey</option>
                                                                                <option value="TM">Turkmenistan</option>
                                                                                <option value="TC">Turks and Caicos Islands</option>
                                                                                <option value="TV">Tuvalu</option>
                                                                                <option value="UG">Uganda</option>
                                                                                <option value="UA">Ukraine</option>
                                                                                <option value="AE">United Arab Emirates</option>
                                                                                <option value="GB">United Kingdom (UK)</option>
                                                                                <option value="US">USA (US)</option>
                                                                                <option value="UY">Uruguay</option>
                                                                                <option value="UZ">Uzbekistan</option>
                                                                                <option value="VU">Vanuatu</option>
                                                                                <option value="VA">Vatican</option>
                                                                                <option value="VE">Venezuela</option>
                                                                                <option value="VN">Vietnam</option>
                                                                                <option value="WF">Wallis and Futuna</option>
                                                                                <option value="EH">Western Sahara</option>
                                                                                <option value="WS">Western Samoa</option>
                                                                                <option value="YE">Yemen</option>
                                                                                <option value="ZM">Zambia</option>
                                                                                <option value="ZW">Zimbabwe</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row row">
                                                                    <div class="form-group col-lg-6">
                                                                        <input required="required" placeholder="State / Country" name="name" type="text">
                                                                    </div>
                                                                    <div class="form-group col-lg-6">
                                                                        <input required="required" placeholder="PostCode / ZIP" name="name" type="text">
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                   <div class="col-lg-5">

                            </div>

                                                </div> -->
                </div>
                <div class="col-lg-4">
                    <div class="border p-md-4 cart-totals ml-30">
                        <!-- Apply Coupon Section -->
                        <div class="coupon-section mb-30">
                            <h4 class="mb-10" style="color: #253D4E; font-weight: 600;">Apply Coupon</h4>
                            <p class="mb-20" style="color: #7E7E7E; font-size: 14px;">Using coupon Code?</p>
                            <div class="d-flex coupon-input-wrapper">
                                <input type="text" id="cart_coupon_code" class="form-control"
                                    placeholder="Enter Your Coupon"
                                    style="border-radius: 30px 0 0 30px; border: 1px solid #e5e5e5; padding: 12px 20px; flex: 1;">
                                <button type="button" id="cart_apply_coupon_btn" class="btn"
                                    style="background: #3BB77E; color: #fff; border-radius: 0 30px 30px 0; padding: 12px 25px; display: flex; align-items: center; gap: 8px;">
                                    <i class="fi-rs-label"></i> Apply
                                </button>
                            </div>
                            <div id="cart_coupon_message" class="mt-10" style="font-size: 13px;"></div>
                            <!-- Applied coupon info -->
                            <div id="applied_coupon_info" class="mt-15" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center p-10"
                                    style="background: #e8f5e9; border-radius: 8px;">
                                    <span class="text-success"><i class="fi-rs-check mr-5"></i> Coupon Applied: <strong
                                            id="applied_coupon_code"></strong></span>
                                    <a href="javascript:void(0)" onclick="removeCartCoupon()" class="text-danger"
                                        style="font-size: 12px;">Remove</a>
                                </div>
                            </div>
                        </div>
                        <div class="divider-2 mb-20"></div>
                        <div class="table-responsive">
                            <table class="table no-border">
                                <tbody>
                                    <!-- <tr>
                                                                    <td class="cart_total_label">
                                                                        <h6 class="text-muted">Subtotal</h6>
                                                                    </td>
                                                                    <td class="cart_total_amount">
                                                                        <h4 class="text-brand text-end" id="cart-subtotal">₹{{ number_format($subtotal, 2) }}</h4>
                                                                    </td>
                                                                </tr> -->
                                    <!-- <tr>
                                                                    <td scope="col" colspan="2">
                                                                        <div class="divider-2 mt-10 mb-10"></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="cart_total_label">
                                                                        <h6 class="text-muted">Shipping</h6>
                                                                    </td>
                                                                    <td class="cart_total_amount">
                                                                        <h5 class="text-heading text-end">Free</h5>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="cart_total_label">
                                                                        <h6 class="text-muted">Estimate for</h6>
                                                                    </td>
                                                                    <td class="cart_total_amount">
                                                                        <h5 class="text-heading text-end">India</h5>
                                                                    </td>
                                                                </tr> -->
                                    <!-- <tr>
                                                                    <td scope="col" colspan="2">
                                                                        <div class="divider-2 mt-10 mb-10"></div>
                                                                    </td>
                                                                </tr> -->
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Subtotal</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-body text-end" id="cart-subtotal">
                                                ₹{{ number_format($subtotal, 0) }}</h4>
                                        </td>
                                    </tr>
                                    <tr id="cart_coupon_discount_row" style="display: none;">
                                        <td class="cart_total_label">
                                            <h6 class="text-success">Coupon Discount</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-success text-end" id="cart-coupon-discount">-₹0</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="col" colspan="2">
                                            <div class="divider-2 mt-10 mb-10"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted"><strong>Total</strong></h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end" id="cart-total">₹{{ number_format($total, 0) }}
                                            </h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('checkout-order') }}" class="btn mb-20 w-100">Proceed To CheckOut<i
                                class="fi-rs-sign-out ml-15"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        // CSRF To    ken for AJAX requests
        const csrfToken = '{{ csrf_token() }}';
        const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

        /**
         * ADD TO CART - LOGIN REQUIRED
         */
        function addToCart(productId, event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route("add-to-cart") }}',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    product_id: productId,
                    selected_quantity: 1
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);

                        // Update cart count in header
                        $('#header-cart-count').text(response.cartCount);
                        $('#bottom-header-cart-count').text(response.cartCount);
                        $('#mobile-cart-count').text(response.cartCount);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr) {
                    const errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong!';
                    toastr.error(errorMsg, 'Error');
                    console.log(xhr.responseText);
                }
            });
        }

        /**
         * CART QTY HANDLERS
         * shop.js attaches direct handlers with stopImmediatePropagation() on .qty-up/.qty-down,
         * which blocks any delegated handlers from firing. So we MUST:
         * 1. Unbind shop.js handlers
         * 2. Attach our own DIRECT handlers that handle both qty change + AJAX price update
         */
        $(document).ready(function() {
            // Step 1: Remove ALL existing click handlers set by shop.js
            $('.detail-qty .qty-up').off('click');
            $('.detail-qty .qty-down').off('click');

            // Step 2: Attach fresh direct handlers
            $('.detail-qty .qty-up').on('click', function(event) {
                event.preventDefault();
                event.stopImmediatePropagation();

                var container = $(this).closest('.detail-qty');
                var qtyInput = container.find('.qty-val');
                var itemId = qtyInput.data('item-id');

                // Only process cart items (ones with data-item-id)
                if (!itemId) return false;

                var currentQty = parseInt(qtyInput.val()) || 1;
                qtyInput.val(currentQty + 1);
                updateCartQuantity(qtyInput[0], itemId);
                return false;
            });

            $('.detail-qty .qty-down').on('click', function(event) {
                event.preventDefault();
                event.stopImmediatePropagation();

                var container = $(this).closest('.detail-qty');
                var qtyInput = container.find('.qty-val');
                var itemId = qtyInput.data('item-id');

                // Only process cart items (ones with data-item-id)
                if (!itemId) return false;

                var currentQty = parseInt(qtyInput.val()) || 1;
                if (currentQty > 1) {
                    qtyInput.val(currentQty - 1);
                    updateCartQuantity(qtyInput[0], itemId);
                }
                return false;
            });
        });

        /**
         * Update cart quantity via AJAX
         */
        function updateCartQuantity(input, itemId) {
            const newQty = parseInt($(input).val()) || 1;

            if (newQty < 1) {
                toastr.warning('Quantity must be at least 1', 'Warning');
                $(input).val(1);
                return;
            }

            console.log('Updating quantity for item:', itemId, 'to:', newQty);

            $.ajax({
                url: '{{ route("update.cart.qty") }}',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    cart_id: itemId,
                    quantity: newQty
                },
                success: function (response) {
                    console.log('Update response:', response);
                    if (response.success) {
                        const formattedRowTotal = '₹' + parseFloat(response.row_total).toFixed(2);
                        const formattedSubtotal = '₹' + parseFloat(response.subtotal).toFixed(2);
                        const formattedTotal = '₹' + parseFloat(response.total).toFixed(2);

                        // Update ALL subtotal elements with this itemId (Desktop and Mobile)
                        $('.subtotal-' + itemId).each(function() {
                            $(this).text(formattedRowTotal);
                        });

                        // Update cart totals
                        $('#cart-subtotal').text(formattedSubtotal);
                        $('#cart-total').text(formattedTotal);

                        // Update header cart count if available
                        if (response.cartCount !== undefined) {
                            $('#header-cart-count, #bottom-header-cart-count, #mobile-cart-count, #top-header-cart-count, #mobile-header-cart-count').text(response.cartCount);
                        }

                        toastr.success('Cart updated successfully', 'Success');
                    } else {
                        toastr.error('Error: ' + (response.message || 'Failed to update quantity'), 'Error');
                    }
                },
                error: function (xhr) {
                    const errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Failed to update quantity';
                    console.error('AJAX Error:', xhr);
                    toastr.error(errorMsg, 'Error');
                }
            });
        }

        /**
         * Remove item from cart
         */
        function removeFromCart(itemId) {
            if (confirm('Are you sure you want to remove this item?')) {
                $.ajax({
                    url: '{{ route("remove.from.cart") }}',
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        cart_id: itemId
                    },
                    success: function (response) {
                        if (response.success) {
                            // Remove the row from table - find row with matching input value
                            const rowToRemove = $('input[type="checkbox"][value="' + itemId + '"]').closest('tr');

                            rowToRemove.fadeOut(300, function () {
                                $(this).remove();

                                // Update cart count in header
                                if (response.cartCount === 0) {
                                    toastr.success('Item removed from cart Successfully');
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1500);
                                } else {
                                    // Update totals in sidebar
                                    $('#cart-subtotal').text('₹' + parseFloat(response.subtotal).toFixed(2));
                                    $('#cart-total').text('₹' + parseFloat(response.total).toFixed(2));

                                    // Update product count in header
                                    $('.text-brand').text(response.cartCount);
                                    toastr.success('Item removed from cart', 'Success');
                                }
                            });
                        } else {
                            toastr.error('Error: ' + response.message, 'Error');
                        }
                    },
                    error: function (xhr) {
                        const errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Failed to remove item from cart';
                        toastr.error(errorMsg, 'Error');
                        console.error(xhr);
                    }
                });
            }
        }

        /**
         * Clear entire cart
         */
        function clearCart() {
            if (confirm('Are you sure you want to clear your entire cart?')) {
                $.ajax({
                    url: '{{ route("clear.cart") }}',
                    type: 'POST',
                    data: {
                        _token: csrfToken
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Cart cleared successfully');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            toastr.error('Error: ' + response.message, 'Error');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Failed to clear cart', 'Error');
                        console.error(xhr);
                    }
                });
            }
        }

        /**
         * Update cart (optional - for update button)
         */
        function updateCart() {
            toastr.info('Cart updated successfully', 'Info');
        }

        // Cart Coupon Variables
        let cartCouponDiscount = 0;
        let appliedCouponCode = null;
        const cartSubtotal = {{ $subtotal }};

        /**
         * Apply coupon in cart
         */
        $('#cart_apply_coupon_btn').click(function () {
            var code = $('#cart_coupon_code').val().trim();
            if (!code) {
                $('#cart_coupon_message').html('<span class="text-danger">Please enter a coupon code</span>');
                return;
            }

            $(this).prop('disabled', true).html('<i class="fi-rs-spinner"></i> Applying...');

            $.ajax({
                url: "{{ route('checkout.apply-coupon') }}",
                type: 'POST',
                data: {
                    _token: csrfToken,
                    coupon_code: code,
                    subtotal: cartSubtotal
                },
                success: function (res) {
                    if (res.success) {
                        cartCouponDiscount = res.coupon.discount;
                        appliedCouponCode = res.coupon.code;

                        // Update UI
                        $('#cart_coupon_message').html('<span class="text-success">' + res.message + '</span>');
                        $('#cart_coupon_code').prop('readonly', true);
                        $('#cart_apply_coupon_btn').html('<i class="fi-rs-check"></i> Applied').addClass('btn-applied');

                        // Show applied coupon info
                        $('#applied_coupon_code').text(appliedCouponCode);
                        $('#applied_coupon_info').slideDown();

                        // Show and update coupon discount row
                        $('#cart_coupon_discount_row').show();
                        $('#cart-coupon-discount').text('-₹' + cartCouponDiscount.toFixed(0));

                        // Update total
                        const newTotal = cartSubtotal - cartCouponDiscount;
                        $('#cart-total').text('₹' + newTotal.toFixed(0));

                        // Store in session for checkout
                        storeCouponInSession(appliedCouponCode, cartCouponDiscount);

                        toastr.success(res.message, 'Success');
                    } else {
                        $('#cart_coupon_message').html('<span class="text-danger">' + res.message + '</span>');
                        $('#cart_apply_coupon_btn').prop('disabled', false).html('<i class="fi-rs-label"></i> Apply');
                    }
                },
                error: function (xhr) {
                    const errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong';
                    $('#cart_coupon_message').html('<span class="text-danger">' + errorMsg + '</span>');
                    $('#cart_apply_coupon_btn').prop('disabled', false).html('<i class="fi-rs-label"></i> Apply');
                }
            });
        });

        /**
         * Remove coupon from cart
         */
        function removeCartCoupon() {
            cartCouponDiscount = 0;
            appliedCouponCode = null;

            // Reset UI
            $('#cart_coupon_code').val('').prop('readonly', false);
            $('#cart_apply_coupon_btn').prop('disabled', false).html('<i class="fi-rs-label"></i> Apply').removeClass('btn-applied');
            $('#cart_coupon_message').html('');
            $('#applied_coupon_info').slideUp();

            // Hide coupon discount row
            $('#cart_coupon_discount_row').hide();
            $('#cart-coupon-discount').text('-₹0');

            // Reset total
            $('#cart-total').text('₹' + cartSubtotal.toFixed(0));

            // Clear session
            clearCouponFromSession();

            toastr.info('Coupon removed', 'Info');
        }

        /**
         * Store coupon in session for checkout
         */
        function storeCouponInSession(code, discount) {
            $.ajax({
                url: "{{ route('cart.store-coupon') }}",
                type: 'POST',
                data: {
                    _token: csrfToken,
                    coupon_code: code,
                    coupon_discount: discount
                },
                success: function (res) {
                    console.log('Coupon stored in session');
                },
                error: function (xhr) {
                    console.error('Failed to store coupon in session');
                }
            });
        }

        /**
         * Clear coupon from session
         */
        function clearCouponFromSession() {
            $.ajax({
                url: "{{ route('cart.clear-coupon') }}",
                type: 'POST',
                data: {
                    _token: csrfToken
                },
                success: function (res) {
                    console.log('Coupon cleared from session');
                },
                error: function (xhr) {
                    console.error('Failed to clear coupon from session');
                }
            });
        }

        // Check if coupon is already applied (on page load)
        @if(session('cart_coupon_code'))
            $(document).ready(function () {
                cartCouponDiscount = {{ session('cart_coupon_discount', 0) }};
                appliedCouponCode = '{{ session('cart_coupon_code') }}';

                $('#cart_coupon_code').val(appliedCouponCode).prop('readonly', true);
                $('#cart_apply_coupon_btn').html('<i class="fi-rs-check"></i> Applied').addClass('btn-applied').prop('disabled', true);
                $('#applied_coupon_code').text(appliedCouponCode);
                $('#applied_coupon_info').show();
                $('#cart_coupon_discount_row').show();
                $('#cart-coupon-discount').text('-₹' + cartCouponDiscount.toFixed(0));

                const newTotal = cartSubtotal - cartCouponDiscount;
                $('#cart-total').text('₹' + newTotal.toFixed(0));
            });
        @endif
    </script>
@endpush