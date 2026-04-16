<?php $__env->startSection('title', 'Report Details - AquaReport'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="<?php echo e(route('dashboard')); ?>" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Report #<?php echo e($report->id); ?></h1>
                <p class="text-gray-500">Submitted <?php echo e($report->created_at->format('F d, Y \a\t h:i A')); ?></p>
            </div>
        </div>
        <?php if($report->status == 'Pending'): ?>
            <span class="status-pending inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold">
                <span class="w-2 h-2 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                Pending Review
            </span>
        <?php elseif($report->status == 'In Progress'): ?>
            <span class="status-progress inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold">
                <span class="w-2 h-2 rounded-full bg-blue-500 mr-2 animate-spin"></span>
                In Progress
            </span>
        <?php else: ?>
            <span class="status-resolved inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                Resolved
            </span>
        <?php endif; ?>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <div class="glass-card rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6"><?php echo e($report->title); ?></h2>

            <div class="grid grid-cols-2 gap-6 mb-8">
                <div class="p-4 rounded-xl bg-ocean-50">
                    <p class="text-sm text-ocean-600 font-medium mb-1">Issue Type</p>
                    <p class="text-gray-900 font-semibold"><?php echo e($report->issue_type); ?></p>
                </div>
                <div class="p-4 rounded-xl bg-aqua-50">
                    <p class="text-sm text-aqua-600 font-medium mb-1">Location</p>
                    <p class="text-gray-900 font-semibold"><?php echo e($report->location); ?></p>
                </div>
                <?php if($report->latitude && $report->longitude): ?>
                    <div class="p-4 rounded-xl bg-gray-50">
                        <p class="text-sm text-gray-500 font-medium mb-1">Coordinates</p>
                        <p class="text-gray-900 font-mono text-sm"><?php echo e($report->latitude); ?>, <?php echo e($report->longitude); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Description</h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap"><?php echo e($report->description); ?></p>
            </div>

            <?php if($report->image): ?>
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Attached Image</h3>
                    <div class="rounded-2xl overflow-hidden shadow-lg">
                        <img src="<?php echo e(asset('storage/' . $report->image)); ?>" alt="Report image" class="w-full h-auto">
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if($report->updates->count() > 0): ?>
            <div class="glass-card rounded-2xl shadow-xl p-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Status Updates
                </h3>
                <div class="space-y-4">
                    <?php $__currentLoopData = $report->updates->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $update): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-start space-x-4 p-4 rounded-xl bg-gradient-to-r from-ocean-50 to-transparent border border-ocean-100">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-ocean-500 to-aqua-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-2">
                                    <p class="text-sm font-semibold text-gray-900"><?php echo e($update->admin->name); ?></p>
                                    <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded-full"><?php echo e($update->created_at->format('M d, Y h:i A')); ?></span>
                                </div>
                                <div class="mb-2">
                                    <?php if($update->status == 'In Progress'): ?>
                                        <span class="status-progress inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium">
                                            Moved to In Progress
                                        </span>
                                    <?php elseif($update->status == 'Resolved'): ?>
                                        <span class="status-resolved inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium">
                                            Marked as Resolved
                                        </span>
                                    <?php else: ?>
                                        <span class="status-pending inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium">
                                            <?php echo e($update->status); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-sm text-gray-600"><?php echo e($update->comment); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="lg:col-span-1">
        <div class="glass-card rounded-2xl shadow-xl p-6 sticky top-24">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Report Timeline</h3>
            <div class="relative">
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                <div class="space-y-6">
                    <div class="relative flex items-start space-x-4">
                        <div class="w-8 h-8 rounded-full bg-ocean-500 flex items-center justify-center z-10">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Report Submitted</p>
                            <p class="text-xs text-gray-500"><?php echo e($report->created_at->format('M d, Y')); ?></p>
                        </div>
                    </div>
                    <?php if($report->updates->count() > 0): ?>
                        <?php $__currentLoopData = $report->updates->sortBy('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $update): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="relative flex items-start space-x-4">
                                <div class="w-8 h-8 rounded-full <?php echo e($update->status == 'Resolved' ? 'bg-green-500' : 'bg-blue-500'); ?> flex items-center justify-center z-10">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900"><?php echo e($update->status); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($update->created_at->format('M d, Y')); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Benaiah L\OneDrive\Documents\Water Supply Reporting System\resources\views/reports/show.blade.php ENDPATH**/ ?>