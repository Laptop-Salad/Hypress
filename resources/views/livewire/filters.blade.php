<div class="mt-6">
    <div class="max-w-sm min-w-40">
        <label for="asset_type_filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
        <select wire:model.live="asset_type" id="asset_type_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="all">All Asset Types</option>
            <option value="assets">Subsea Assets</option>
            <option value="pipelines">Subsea Pipelines</option>
            <option value="vessels">Surf Vessels</option>
            <option value="pois">Point of Interests</option>
        </select>
    </div>
</div>
