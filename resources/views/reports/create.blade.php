@extends('layouts.app')
@section('title', 'Submit Report - AquaReport')

@section('content')
<style>
    .section-card {
        @apply bg-gray-50/50 rounded-2xl p-6 border border-gray-100;
    }
    .image-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px;
        margin-top: 12px;
    }
    .image-preview-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.2s;
    }
    .image-preview-item:hover {
        border-color: #0ea5e9;
        transform: scale(1.02);
    }
    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .image-preview-item .remove-btn {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 24px;
        height: 24px;
        background: rgba(239, 68, 68, 0.9);
        border: none;
        border-radius: 50%;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .image-preview-item:hover .remove-btn {
        opacity: 1;
    }
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .modal.active {
        display: flex;
    }
    .modal img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 12px;
    }
    .modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 20px;
    }
</style>

<div class="mb-8">
    <div class="flex items-center space-x-4 mb-2">
        <a href="{{ route('dashboard') }}" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Submit Water Issue Report</h1>
    </div>
    <p class="text-gray-600 ml-14">Help us improve water supply by reporting issues in your area</p>
</div>

<div id="imageModal" class="modal" onclick="closeModal(event)">
    <button class="modal-close" onclick="closeModal(event)">&times;</button>
    <img id="modalImage" src="" alt="Full size preview">
</div>

<div class="grid lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <div class="glass-card rounded-2xl shadow-xl p-8">
            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" id="reportForm">
                @csrf

                <div class="space-y-8">
                    <div class="section-card">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-ocean-500 to-aqua-600 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                                <p class="text-sm text-gray-500">Tell us about the issue</p>
                            </div>
                        </div>
                        <div class="space-y-4 pl-13">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Report Title</label>
                                <input type="text" name="title" id="title" required
                                    class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('title') border-red-300 bg-red-50 @enderror"
                                    placeholder="e.g., Water leak on Main Street" value="{{ old('title') }}">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="issue_type" class="block text-sm font-medium text-gray-700 mb-2">Issue Type</label>
                                <div class="relative">
                                    <select name="issue_type" id="issue_type" required
                                        class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent appearance-none bg-white @error('issue_type') border-red-300 bg-red-50 @enderror">
                                        <option value="">Select issue type</option>
                                        <option value="Leak" {{ old('issue_type') == 'Leak' ? 'selected' : '' }}>Leak</option>
                                        <option value="No water" {{ old('issue_type') == 'No water' ? 'selected' : '' }}>No water</option>
                                        <option value="Low pressure" {{ old('issue_type') == 'Low pressure' ? 'selected' : '' }}>Low pressure</option>
                                        <option value="Contaminated water" {{ old('issue_type') == 'Contaminated water' ? 'selected' : '' }}>Contaminated water</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('issue_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="section-card">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Location</h3>
                                <p class="text-sm text-gray-500">Where is the issue located?</p>
                            </div>
                        </div>
                        <div class="space-y-4 pl-13">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-medium text-gray-700">GPS Coordinates</label>
                                    <button type="button" id="getLocationBtn" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:shadow-lg transition font-medium text-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span id="locationBtnText">Get GPS Location</span>
                                    </button>
                                </div>
                                <div id="locationStatus" class="mb-3 text-sm hidden"></div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <input type="number" step="any" name="latitude" id="latitude"
                                            class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('latitude') border-red-300 bg-red-50 @enderror"
                                            placeholder="Latitude" value="{{ old('latitude') }}">
                                    </div>
                                    <div>
                                        <input type="number" step="any" name="longitude" id="longitude"
                                            class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('longitude') border-red-300 bg-red-50 @enderror"
                                            placeholder="Longitude" value="{{ old('longitude') }}">
                                    </div>
                                </div>
                                @error('latitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div id="mapContainer" class="hidden rounded-xl overflow-hidden border border-gray-200 h-64">
                                <iframe id="mapFrame" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                            <div class="border-t border-gray-200 pt-4">
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Landmark / Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="location" id="location" required
                                        class="input-water w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('location') border-red-300 bg-red-50 @enderror"
                                        placeholder="Enter landmark or address" value="{{ old('location') }}">
                                </div>
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="section-card">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Details</h3>
                                <p class="text-sm text-gray-500">Describe the issue in detail</p>
                            </div>
                        </div>
                        <div class="pl-13">
                            <textarea name="description" id="description" rows="4" required
                                class="input-water w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent resize-none @error('description') border-red-300 bg-red-50 @enderror"
                                placeholder="Describe the issue, when it started, and any other relevant details...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="section-card">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Photos <span class="text-sm font-normal text-gray-500">(Optional)</span></h3>
                                <p class="text-sm text-gray-500">Add up to 10 images</p>
                            </div>
                        </div>
                        <div class="pl-13 space-y-4">
                            <div class="flex flex-wrap gap-3">
                                <label class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-ocean-500 to-aqua-600 text-white rounded-xl hover:shadow-lg transition font-medium text-sm cursor-pointer">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Upload Images</span>
                                    <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden" onchange="handleImageSelect(this)">
                                </label>
                                <label class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl hover:shadow-lg transition font-medium text-sm cursor-pointer">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>Take Photo</span>
                                    <input type="file" name="images[]" id="cameraImage" accept="image/*" capture="environment" multiple class="hidden" onchange="handleImageSelect(this)">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">JPG, PNG up to 5MB each. Click images to preview.</p>
                            <div id="imagePreviewContainer" class="image-preview-container"></div>
                            <p id="imageCount" class="text-sm text-gray-500 hidden">0/10 images selected</p>
                            @error('images')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-8 mt-8 border-t border-gray-100">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition">
                        Cancel
                    </a>
                    <button type="submit" class="btn-water px-8 py-3 rounded-xl text-white font-semibold shadow-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Submit Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="glass-card rounded-2xl shadow-xl p-6 sticky top-24">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Tips for Reporting
            </h3>
            <ul class="space-y-4">
                <li class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-ocean-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Use GPS</p>
                        <p class="text-xs text-gray-500">Click button for accurate location</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-aqua-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-aqua-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Add Photos</p>
                        <p class="text-xs text-gray-500">Upload or capture up to 10 images</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-nature-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-nature-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Include Timing</p>
                        <p class="text-xs text-gray-500">Note when issue started</p>
                    </div>
                </li>
            </ul>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Reviewed within 24 hours</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedFiles = [];
const MAX_IMAGES = 10;

function handleImageSelect(input) {
    if (input.files && input.files.length > 0) {
        const remainingSlots = MAX_IMAGES - selectedFiles.length;
        const filesToAdd = Array.from(input.files).slice(0, remainingSlots);
        
        filesToAdd.forEach(file => {
            if (file.type.startsWith('image/')) {
                selectedFiles.push(file);
            }
        });
        
        updateImagePreview();
        
        input.value = '';
    }
}

function updateImagePreview() {
    const container = document.getElementById('imagePreviewContainer');
    const countEl = document.getElementById('imageCount');
    
    container.innerHTML = '';
    
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'image-preview-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Preview ${index + 1}">
                <button type="button" class="remove-btn" onclick="removeImage(${index})">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            div.onclick = function(event) {
                if (!event.target.closest('.remove-btn')) {
                    openModal(e.target.result);
                }
            };
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
    
    if (selectedFiles.length > 0) {
        countEl.classList.remove('hidden');
        countEl.textContent = `${selectedFiles.length}/${MAX_IMAGES} images selected`;
    } else {
        countEl.classList.add('hidden');
    }
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    updateImagePreview();
}

function openModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(event) {
    if (event.target.id === 'imageModal' || event.target.classList.contains('modal-close')) {
        document.getElementById('imageModal').classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.getElementById('reportForm').addEventListener('submit', function(e) {
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });
    
    const fileInput = document.getElementById('images');
    Object.defineProperty(fileInput, 'files', {
        value: dataTransfer.files,
        writable: false
    });
    
    if (selectedFiles.length === 0) {
        fileInput.removeAttribute('name');
    }
});

document.getElementById('getLocationBtn').addEventListener('click', function() {
    const btn = this;
    const btnText = document.getElementById('locationBtnText');
    const statusDiv = document.getElementById('locationStatus');
    const mapContainer = document.getElementById('mapContainer');
    const mapFrame = document.getElementById('mapFrame');
    
    btnText.textContent = 'Getting location...';
    btn.disabled = true;
    statusDiv.classList.remove('hidden');
    statusDiv.className = 'mb-3 text-sm text-ocean-600';
    statusDiv.innerHTML = '<span class="inline-block animate-spin mr-2">⟳</span> Getting your location...';
    
    if (!navigator.geolocation) {
        statusDiv.className = 'mb-3 text-sm text-red-600';
        statusDiv.textContent = 'Geolocation is not supported by your browser';
        btnText.textContent = 'Get Current Location';
        btn.disabled = false;
        return;
    }
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude.toFixed(6);
            const lng = position.coords.longitude.toFixed(6);
            
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            
            mapContainer.classList.remove('hidden');
            mapFrame.src = `https://www.google.com/maps?q=${lat},${lng}&zoom=16&output=embed`;
            
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data.display_name) {
                        document.getElementById('location').value = data.display_name;
                    }
                })
                .catch(() => {});
            
            statusDiv.className = 'mb-3 text-sm text-green-600';
            statusDiv.innerHTML = '✓ Location captured! Map and address auto-filled.';
            
            btnText.textContent = 'Update Location';
            btn.disabled = false;
        },
        function(error) {
            let errorMsg = 'Unable to get location. ';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMsg += 'Please allow location access in your browser settings.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMsg += 'Location information is unavailable.';
                    break;
                case error.TIMEOUT:
                    errorMsg += 'Location request timed out.';
                    break;
                default:
                    errorMsg += 'An unknown error occurred.';
            }
            statusDiv.className = 'mb-3 text-sm text-red-600';
            statusDiv.textContent = errorMsg;
            btnText.textContent = 'Get Current Location';
            btn.disabled = false;
        },
        {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 0
        }
    );
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal({target: document.getElementById('imageModal')});
    }
});

window.addEventListener('load', function() {
    const lat = document.getElementById('latitude').value;
    const lng = document.getElementById('longitude').value;
    if (lat && lng) {
        const mapContainer = document.getElementById('mapContainer');
        const mapFrame = document.getElementById('mapFrame');
        mapContainer.classList.remove('hidden');
        mapFrame.src = `https://www.google.com/maps?q=${lat},${lng}&zoom=16&output=embed`;
        document.getElementById('locationBtnText').textContent = 'Update Location';
    }
});
</script>
@endsection
