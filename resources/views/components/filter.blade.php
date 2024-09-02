<div class="fi-header flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between pt-3">
    <div>
        <nav class="fi-breadcrumbs mb-2 hidden sm:block">
            <ol class="fi-breadcrumbs-list flex flex-wrap items-center gap-x-2">
                <li class="fi-breadcrumbs-item flex gap-x-2">
                    <a href="{{ route('filament.admin.pages.dashboard') }}" class="fi-breadcrumbs-item-label text-sm font-medium text-gray-500 dark:text-gray-400 transition duration-75 hover:text-gray-700 dark:hover:text-gray-200">
                        Dashboard
                    </a>
                </li>
                <li class="fi-breadcrumbs-item flex gap-x-2">
                    <svg class="fi-breadcrumbs-item-separator flex h-5 w-5 text-gray-400 dark:text-gray-500 rtl:hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="fi-breadcrumbs-item-label text-sm font-medium text-gray-500 dark:text-gray-400">
                        Appearance
                    </span>
                </li>
                <li class="fi-breadcrumbs-item flex gap-x-2">
                    <svg class="fi-breadcrumbs-item-separator flex h-5 w-5 text-gray-400 dark:text-gray-500 rtl:hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="fi-breadcrumbs-item-label text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ request()->query('filter') === 'pages' ? 'Pages' : 'Widgets' }}
                    </span>
                </li>
            </ol>
        </nav>
    </div>
    <div class="flex justify-end space-x-4 mb-4 mx-2 px-2 gap-2">
        <a href="{{ request()->query('filter') === 'widgets' ? '#' : '?filter=widgets' }}" 
           @class([
            'rounded px-4 py-2',
            'bg-selected text-white' => (request()->query('filter') === 'widgets' || !request()->has('filter')),
            'bg-white' => !(request()->query('filter') === 'widgets' || !request()->has('filter')),
           ])
           >
            Widgets
        </a>
        <a href="{{ request()->query('filter') === 'pages' ? '#' : '?filter=pages' }}" 
           @class([
            'rounded px-4 py-2',
            'bg-selected text-white' => (request()->query('filter') === 'pages'),
            'bg-white' => !request()->has('filter') || request()->query('filter') !== 'pages',
            ])
           >
            Pages
        </a>
    </div>
</div>

<style>
.bg-selected {
    background-color: #16a085;
}
</style>