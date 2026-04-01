<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium">Name</label>
        <input name="name" value="{{ old('name', $template->name ?? '') }}" class="mt-1 w-full border rounded p-2 @error('name') border-red-500 @enderror" required>
        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Type</label>
        <select name="type" class="mt-1 w-full border rounded p-2 @error('type') border-red-500 @enderror" required>
            <option value="offer_letter" @selected(old('type', $template->type ?? '') === 'offer_letter')>Offer Letter</option>
            <option value="appointment_letter" @selected(old('type', $template->type ?? '') === 'appointment_letter')>Appointment Letter</option>
            <option value="experience_letter" @selected(old('type', $template->type ?? '') === 'experience_letter')>Experience Letter</option>
        </select>
        @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Subject</label>
        <input name="subject" value="{{ old('subject', $template->subject ?? '') }}" class="mt-1 w-full border rounded p-2 @error('subject') border-red-500 @enderror">
        @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Body</label>
        <textarea name="body" rows="8" class="mt-1 w-full border rounded p-2 @error('body') border-red-500 @enderror" required>{{ old('body', $template->body ?? '') }}</textarea>
        <p class="text-xs text-gray-500 mt-1">Use placeholders like @verbatim{{name}}@endverbatim, @verbatim{{designation}}@endverbatim, @verbatim{{date}}@endverbatim.</p>
        @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>
