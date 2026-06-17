@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto" id="barcode-container">
        <!-- Back Button - Hidden on Print -->
        <div class="mb-6 no-print">
            <a href="{{ route('products.show', $product->id) }}"
                class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors duration-300">
                <i class="fas fa-arrow-left"></i>
                Back to Product
            </a>
        </div>

        <!-- Barcode Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden" id="barcode-card">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                            <i class="fas fa-barcode"></i>
                            Barcode Label
                        </h2>
                        <p class="text-indigo-200 mt-1 flex items-center gap-2">
                            <i class="fas fa-tag text-xs"></i>
                            Product identification barcode
                        </p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-full p-3 no-print">
                        <i class="fas fa-print text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Barcode Content -->
            <div class="p-8">
                <!-- Product Info -->
                <div class="text-center mb-8">
                    <h3 class="text-3xl font-bold text-slate-900 mb-2 flex items-center justify-center gap-3">
                        <i class="fas fa-box text-indigo-500 text-2xl"></i>
                        {{ $product->name }}
                    </h3>
                    <div class="flex items-center justify-center gap-4 text-sm text-slate-500 flex-wrap">
                        <span class="inline-flex items-center gap-1">
                            <i class="fas fa-barcode text-indigo-400"></i>
                            SKU: <span class="font-semibold text-slate-700">{{ $product->sku }}</span>
                        </span>
                        @if ($product->category)
                            <span class="inline-flex items-center gap-1">
                                <i class="fas fa-tag text-indigo-400"></i>
                                {{ $product->category->name }}
                            </span>
                        @endif
                        @if ($product->brand)
                            <span class="inline-flex items-center gap-1">
                                <i class="fas fa-building text-indigo-400"></i>
                                {{ $product->brand->name }}
                            </span>
                        @endif
                        <span class="inline-flex items-center gap-1">
                            <i class="fas fa-warehouse text-indigo-400"></i>
                            Stock: <span class="font-semibold text-slate-700">{{ $product->total_stock }}</span>
                        </span>
                    </div>
                </div>

                <!-- Barcode Image -->
                <div
                    class="flex justify-center mb-8 p-8 bg-gradient-to-br from-slate-50 to-slate-100 rounded-3xl border-2 border-dashed border-slate-300">
                    <div class="bg-white p-6 rounded-2xl shadow-lg barcode-wrapper">
                        {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 2, 80) !!}
                    </div>
                </div>

                <!-- Barcode Number -->
                <div class="text-center mb-8">
                    <p class="text-sm text-slate-500 mb-1 flex items-center justify-center gap-2">
                        <i class="fas fa-hashtag text-indigo-400"></i>
                        Barcode Number
                    </p>
                    <p
                        class="text-2xl font-bold text-slate-900 tracking-wider font-mono bg-slate-50 inline-block px-6 py-3 rounded-xl border border-slate-200">
                        {{ $product->barcode }}
                    </p>
                    <p class="text-xs text-slate-400 mt-2">Code 128 format • {{ strlen($product->barcode) }} digits</p>
                </div>

                <!-- Product Pricing -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-slate-50 rounded-2xl p-4 text-center border border-slate-200">
                        <p class="text-xs text-slate-500 flex items-center justify-center gap-1">
                            <i class="fas fa-shopping-cart text-indigo-400"></i>
                            Purchase Price
                        </p>
                        <p class="text-lg font-semibold text-slate-900 mt-1">
                            {{ $setting->currency ?? 'PKR' }} {{ number_format($product->purchase_price, 0) }}
                        </p>
                    </div>
                    <div class="bg-emerald-50 rounded-2xl p-4 text-center border border-emerald-200">
                        <p class="text-xs text-slate-500 flex items-center justify-center gap-1">
                            <i class="fas fa-tag text-emerald-500"></i>
                            Sale Price
                        </p>
                        <p class="text-lg font-semibold text-emerald-700 mt-1">
                            {{ $setting->currency ?? 'PKR' }} {{ number_format($product->sale_price, 0) }}
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="border-t border-slate-200 pt-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4 text-xs text-slate-400">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-calendar-alt"></i>
                                Generated: {{ now()->format('d M Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-clock"></i>
                                {{ now()->format('h:i A') }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-400">Powered by</span>
                            <span class="text-xs font-semibold text-indigo-600">Product Manager</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons - Hidden on Print -->
            <div class="bg-slate-50 px-8 py-6 border-t border-slate-200 flex flex-col sm:flex-row gap-3 justify-end no-print">
                <a href="{{ route('products.show', $product->id) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-200 px-6 py-3 text-slate-700 hover:bg-slate-300 transition-all duration-300">
                    <i class="fas fa-times"></i>
                    Close
                </a>
                <button onclick="window.print()"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-3 text-white shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:scale-[1.02] transition-all duration-300">
                    <i class="fas fa-print"></i>
                    Print Barcode
                </button>
                <button onclick="window.print()"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-6 py-3 text-white shadow-lg shadow-emerald-200 hover:shadow-emerald-300 hover:scale-[1.02] transition-all duration-300">
                    <i class="fas fa-download"></i>
                    Download PDF
                </button>
            </div>
        </div>

        <!-- Additional Info - Hidden on Print -->
        <div class="mt-6 bg-blue-50 rounded-2xl p-4 border border-blue-200 flex items-start gap-3 no-print">
            <i class="fas fa-info-circle text-blue-500 text-xl mt-0.5"></i>
            <div>
                <p class="text-sm text-blue-800 font-semibold">Printing Tips</p>
                <p class="text-xs text-blue-600 mt-1">
                    Use thermal or label printers for best results.
                    Ensure paper size is set to 4x6 inches for optimal barcode scanning.
                </p>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Print Styles */
        @media print {
            /* Hide everything except the barcode card */
            body * {
                visibility: hidden;
            }
            
            /* Show only the barcode card and its children */
            #barcode-card,
            #barcode-card * {
                visibility: visible;
            }
            
            /* Position the barcode card */
            #barcode-card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 10px !important;
                box-shadow: none !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 0 !important;
                background: white !important;
            }
            
            /* Hide elements with no-print class */
            .no-print,
            .no-print * {
                display: none !important;
                visibility: hidden !important;
            }
            
            /* Keep colors for print */
            .bg-gradient-to-r {
                background: #4f46e5 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .bg-slate-50,
            .bg-emerald-50,
            .bg-gradient-to-br {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            /* Remove shadows for print */
            .shadow-2xl,
            .shadow-lg,
            .shadow-xl {
                box-shadow: none !important;
            }
            
            /* Keep border styles */
            .border-dashed {
                border-style: solid !important;
            }
            
            /* Ensure barcode image is visible */
            .barcode-wrapper {
                background: white !important;
                padding: 20px !important;
                border-radius: 12px !important;
            }
            
            .barcode-wrapper svg {
                max-width: 100%;
                height: auto;
            }
            
            /* Ensure text colors are preserved */
            .text-white {
                color: white !important;
            }
            
            .text-slate-900 {
                color: #0f172a !important;
            }
            
            .text-slate-700 {
                color: #334155 !important;
            }
            
            .text-emerald-700 {
                color: #047857 !important;
            }
            
            /* Page margin for print */
            @page {
                margin: 10mm;
                size: A4;
            }
        }
        
        /* Screen Styles */
        .hover\:scale-\[1\.02\] {
            transition: transform 0.3s ease;
        }
        
        .hover\:scale-\[1\.02\]:hover {
            transform: scale(1.02);
        }
        
        /* Barcode SVG styling */
        .bg-white svg {
            max-width: 100%;
            height: auto;
        }
        
        /* Print button animation */
        .fa-print,
        .fa-download {
            transition: transform 0.3s ease;
        }
        
        button:hover .fa-print,
        button:hover .fa-download {
            transform: scale(1.1);
        }
    </style>
@endpush