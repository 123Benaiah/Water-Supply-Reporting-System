@extends('layouts.app')
@section('title', 'Submit Report - ZAWASU')

@section('content')
<style>
    .camera-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .camera-modal.active {
        display: flex;
    }
    .camera-modal video {
        max-width: 90%;
        max-height: 80%;
        border-radius: 12px;
    }
    .camera-modal .camera-controls {
        position: absolute;
        bottom: 40px;
        display: flex;
        gap: 20px;
    }
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

<div class="mb-4">
    <div class="d-flex align-items-center gap-3 mb-2">
        <a href="{{ route('dashboard') }}" class="p-2 rounded-3 bg-secondary-subtle text-decoration-none">
            <svg width="20" height="20" class="text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="fs-3 fw-bold text-dark">Submit Water Issue Report</h1>
    </div>
    <p class="text-muted ms-5">Help us improve water supply by reporting issues in your area</p>
</div>

<div id="imageModal" class="modal" onclick="closeModal(event)">
    <button class="modal-close" onclick="closeModal(event)">&times;</button>
    <img id="modalImage" src="" alt="Full size preview">
</div>

<div id="cameraModal" class="camera-modal">
    <video id="cameraVideo" autoplay playsinline></video>
    <div class="camera-controls">
        <button type="button" onclick="capturePhoto()" class="rounded-circle bg-white text-ocean-600 d-flex align-items-center justify-content-center border-0" style="width: 64px; height: 64px;">
            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke-width="2"/>
                <circle cx="12" cy="12" r="4"/>
            </svg>
        </button>
        <button type="button" onclick="closeCamera()" class="px-4 py-2 btn btn-secondary">Close</button>
    </div>
    <canvas id="cameraCanvas" class="d-none"></canvas>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-lg">
            <div class="card-body p-4">
                <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" id="reportForm">
                    @csrf

                    <div class="mb-4">
                        <div class="bg-light rounded-3 p-4 border">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-3 bg-ocean-600 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0ea5e9, #0891b2);">
                                    <svg width="20" height="20" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="fs-5 fw-semibold mb-0">Basic Information</h3>
                                    <p class="small text-muted mb-0">Tell us about the issue</p>
                                </div>
                            </div>
                            <div class="ms-5">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Report Title</label>
                                    <input type="text" name="title" id="title" required
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="e.g., Water leak on Main Street" value="{{ old('title') }}">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="issue_type" class="form-label">Issue Type</label>
                                    <select name="issue_type" id="issue_type" required
                                        class="form-select @error('issue_type') is-invalid @enderror">
                                        <option value="">Select issue type</option>
                                        <option value="Leak" {{ old('issue_type') == 'Leak' ? 'selected' : '' }}>Leak</option>
                                        <option value="No water" {{ old('issue_type') == 'No water' ? 'selected' : '' }}>No water</option>
                                        <option value="Low pressure" {{ old('issue_type') == 'Low pressure' ? 'selected' : '' }}>Low pressure</option>
                                        <option value="Contaminated water" {{ old('issue_type') == 'Contaminated water' ? 'selected' : '' }}>Contaminated water</option>
                                    </select>
                                    @error('issue_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    <div class="bg-light rounded-3 p-4 border mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #22c55e, #059669);">
                                <svg width="20" height="20" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="fs-5 fw-semibold mb-0">Location</h3>
                                <p class="small text-muted mb-0">Where is the issue located?</p>
                            </div>
                        </div>
                        <div class="ms-5">
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label">GPS Coordinates</label>
                                    <button type="button" id="getLocationBtn" class="btn btn-success btn-sm">
                                        <svg width="16" height="16" class="me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span id="locationBtnText">Get GPS Location</span>
                                    </button>
                                </div>
                                <div id="locationStatus" class="mb-2 small d-none"></div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" step="any" name="latitude" id="latitude"
                                            class="form-control @error('latitude') is-invalid @enderror"
                                            placeholder="Latitude" value="{{ old('latitude') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" step="any" name="longitude" id="longitude"
                                            class="form-control @error('longitude') is-invalid @enderror"
                                            placeholder="Longitude" value="{{ old('longitude') }}">
                                    </div>
                                </div>
                                @error('latitude')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="mapContainer" class="d-none rounded-3 overflow-hidden border" style="height: 250px;">
                                <iframe id="mapFrame" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                            <div class="border-top pt-3 mt-3">
                                <label for="location" class="form-label">Landmark / Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <svg width="20" height="20" class="text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </span>
                                    <input type="text" name="location" id="location" required
                                        class="form-control @error('location') is-invalid @enderror"
                                        placeholder="Enter landmark or address" value="{{ old('location') }}">
                                </div>
                                @error('location')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-light rounded-3 p-4 border mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #a855f7, #4f46e5);">
                                <svg width="20" height="20" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="fs-5 fw-semibold mb-0">Details</h3>
                                <p class="small text-muted mb-0">Describe the issue in detail</p>
                            </div>
                        </div>
                        <div class="ms-5">
                            <textarea name="description" id="description" rows="4" required
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Describe the issue, when it started, and any other relevant details...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-light rounded-3 p-4 border mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #f59e0b, #ea580c);">
                                <svg width="20" height="20" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="fs-5 fw-semibold mb-0">Photos <span class="small fw-normal text-muted">(Optional)</span></h3>
                                <p class="small text-muted mb-0">Add up to 10 images</p>
                            </div>
                        </div>
                        <div class="ms-5">
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <label class="btn btn-ocean d-inline-flex align-items-center cursor-pointer">
                                    <svg width="20" height="20" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Upload Images</span>
                                    <input type="file" name="images[]" id="images" multiple accept="image/*" class="d-none" onchange="handleImageSelect(this)">
                                </label>
                                <button type="button" onclick="openCamera()" class="btn btn-success d-inline-flex align-items-center">
                                    <svg width="20" height="20" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>Take Photo</span>
                                </button>
                            </div>
                            <p class="small text-muted">JPG, PNG up to 5MB each. Click images to preview.</p>
                            <div id="imagePreviewContainer" class="image-preview-container"></div>
                            <p id="imageCount" class="small text-muted d-none">0/10 images selected</p>
                            @error('images')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-3 pt-4 mt-4 border-top">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-ocean px-4 py-2 d-flex align-items-center shadow-lg">
                            <svg width="20" height="20" class="me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-lg sticky-top" style="top: 80px;">
            <div class="card-body p-4">
                <h3 class="fs-5 fw-semibold mb-3 d-flex align-items-center">
                    <svg width="20" height="20" class="me-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Tips for Reporting
                </h3>
                <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-start gap-2 mb-3">
                        <div class="rounded-2 bg-ocean-100 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                            <svg width="16" height="16" class="text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="small fw-medium mb-0">Use GPS</p>
                            <p class="small text-muted mb-0">Click button for accurate location</p>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-2 mb-3">
                        <div class="rounded-2 bg-info-subtle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                            <svg width="16" height="16" class="text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="small fw-medium mb-0">Add Photos</p>
                            <p class="small text-muted mb-0">Upload or capture up to 10 images</p>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <div class="rounded-2 bg-success-subtle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                            <svg width="16" height="16" class="text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="small fw-medium mb-0">Include Timing</p>
                            <p class="small text-muted mb-0">Note when issue started</p>
                        </div>
                    </li>
                </ul>

                <div class="mt-4 pt-4 border-top">
                    <div class="d-flex align-items-center gap-2 small text-muted">
                        <svg width="20" height="20" class="text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622l-.382-3.016z"/>
                        </svg>
                        <span>Reviewed within 24 hours</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedFiles = [];
const MAX_IMAGES = 10;

function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || 
           ('ontouchstart' in window) ||
           (navigator.maxTouchPoints > 0);
}

function updateCameraButton() {}

async function openCamera() {
    const modal = document.getElementById('cameraModal');
    const video = document.getElementById('cameraVideo');
    
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    try {
        const constraints = {
            video: {
                facingMode: isMobile() ? { exact: 'environment' } : 'user',
                width: { ideal: 1920 },
                height: { ideal: 1080 }
            }
        };
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = stream;
    } catch (err) {
        console.error('Camera error:', err);
        alert('Unable to access camera. Please allow camera permissions.');
        closeCamera();
    }
}

function capturePhoto() {
    const video = document.getElementById('cameraVideo');
    const canvas = document.getElementById('cameraCanvas');
    const context = canvas.getContext('2d');
    
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0);
    
    canvas.toBlob(function(blob) {
        const file = new File([blob], 'camera_' + Date.now() + '.jpg', { type: 'image/jpeg' });
        
        if (selectedFiles.length < MAX_IMAGES) {
            selectedFiles.push(file);
            updateImagePreview();
        } else {
            alert('Maximum ' + MAX_IMAGES + ' images allowed');
        }
        
        closeCamera();
    }, 'image/jpeg', 0.9);
}

function closeCamera() {
    const modal = document.getElementById('cameraModal');
    const video = document.getElementById('cameraVideo');
    
    modal.classList.remove('active');
    document.body.style.overflow = '';
    
    if (video.srcObject) {
        video.srcObject.getTracks().forEach(track => track.stop());
        video.srcObject = null;
    }
}

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
        countEl.classList.remove('d-none');
        countEl.textContent = `${selectedFiles.length}/${MAX_IMAGES} images selected`;
    } else {
        countEl.classList.add('d-none');
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
    e.preventDefault();

    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    const loader = document.getElementById('globalLoader');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span>Submitting...</span>';
    if (loader) {
        loader.classList.remove('d-none');
        loader.classList.add('d-flex');
    }

    const formData = new FormData(form);
    formData.delete('images');

    selectedFiles.forEach(file => {
        formData.append('images[]', file);
    });

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success || data.redirect) {
            window.location.href = data.redirect || '{{ route("dashboard") }}';
        } else if (data.errors) {
            alert('Validation errors: ' + Object.values(data.errors).flat().join(', '));
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            if (loader) {
                loader.classList.add('d-none');
                loader.classList.remove('d-flex');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
        if (loader) {
            loader.classList.add('d-none');
            loader.classList.remove('d-flex');
        }
    });
});

document.getElementById('getLocationBtn').addEventListener('click', function() {
    const btn = this;
    const btnText = document.getElementById('locationBtnText');
    const statusDiv = document.getElementById('locationStatus');
    const mapContainer = document.getElementById('mapContainer');
    const mapFrame = document.getElementById('mapFrame');
    
    btnText.textContent = 'Getting location...';
    btn.disabled = true;
    statusDiv.classList.remove('d-none');
    statusDiv.className = 'mb-3 text-sm text-ocean-600';
    statusDiv.innerHTML = '<span class="inline-block animate-spin me-2">⟳</span> Getting your location...';
    
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
            
            mapContainer.classList.remove('d-none');
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
        mapContainer.classList.remove('d-none');
        mapFrame.src = `https://www.google.com/maps?q=${lat},${lng}&zoom=16&output=embed`;
        document.getElementById('locationBtnText').textContent = 'Update Location';
    }
});
</script>
@endsection
