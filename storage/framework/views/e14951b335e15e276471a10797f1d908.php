<?php $__env->startSection('title', 'My Dashboard - AquaReport'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Reports</h1>
            <p class="text-gray-600">Track and manage your water supply issue reports</p>
        </div>
        <a href="<?php echo e(route('reports.create')); ?>" class="btn-water mt-4 md:mt-0 inline-flex items-center px-6 py-3 rounded-xl text-white font-semibold shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Submit New Report
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="glass-card rounded-2xl shadow-lg p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Reports</p>
                <p class="text-4xl font-bold text-gray-900"><?php echo e($reports->total()); ?></p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-ocean-100 to-ocean-200 flex items-center justify-center">
                <svg class="w-7 h-7 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl shadow-lg p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Pending</p>
                <p class="text-4xl font-bold text-amber-600"><?php echo e($reports->where('status', 'Pending')->count()); ?></p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center">
                <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl shadow-lg p-6 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Resolved</p>
                <p class="text-4xl font-bold text-green-600"><?php echo e($reports->where('status', 'Resolved')->count()); ?></p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<?php if($reports->isEmpty()): ?>
    <div class="glass-card rounded-2xl shadow-lg p-12 text-center">
        <div class="w-20 h-20 rounded-full bg-ocean-50 flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-ocean-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Reports Yet</h3>
        <p class="text-gray-500 mb-6 max-w-md mx-auto">You haven't submitted any water supply issue reports. Start by reporting an issue in your area.</p>
        <a href="<?php echo e(route('reports.create')); ?>" class="btn-water inline-flex items-center px-6 py-3 rounded-xl text-white font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Submit Your First Report
        </a>
    </div>
<?php else: ?>
    <div class="glass-card rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-ocean-50 to-aqua-50">
            <h2 class="text-lg font-semibold text-gray-900">Recent Reports</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-ocean-50/30 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">#<?php echo e($report->id); ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 max-w-xs truncate"><?php echo e($report->title); ?></div>
                                <div class="text-xs text-gray-500 truncate max-w-xs"><?php echo e($report->location); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-ocean-100 text-ocean-800">
                                    <?php if($report->issue_type == 'Leak'): ?>
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 3.636a1 1 0 010 1.414 7 7 0 000 9.9 1 1 0 11-1.414 1.414 9 9 0 010-12.728 1 1 0 011.414 0zm9.9 0a1 1 0 011.414 0 9 9 0 010 12.728 1 1 0 11-1.414-1.414 7 7 0 000-9.9 1 1 0 010-1.414zM8 10.93a1 1 0 011.414 0 7 7 0 000 9.9 1 1 0 11-1.414-1.414 9 9 0 010-12.728 1 1 0 010 1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    <?php elseif($report->issue_type == 'Contaminated water'): ?>
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    <?php elseif($report->issue_type == 'No water'): ?>
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                    <?php endif; ?>
                                    <?php echo e($report->issue_type); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($report->status == 'Pending'): ?>
                                    <span class="status-pending inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                                        Pending
                                    </span>
                                <?php elseif($report->status == 'In Progress'): ?>
                                    <span class="status-progress inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-blue-500 mr-2 animate-spin"></span>
                                        In Progress
                                    </span>
                                <?php else: ?>
                                    <span class="status-resolved inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Resolved
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($report->created_at->format('M d, Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="<?php echo e(route('reports.show', $report)); ?>" class="inline-flex items-center px-3 py-1.5 rounded-lg text-ocean-600 hover:bg-ocean-50 font-medium transition">
                                    View Details
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            <?php echo e($reports->links()); ?>

        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Benaiah L\OneDrive\Documents\Water Supply Reporting System\resources\views/reports/dashboard.blade.php ENDPATH**/ ?>