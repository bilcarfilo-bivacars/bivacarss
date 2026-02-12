@php($row = $row ?? null)
<label>Key <input type="text" name="key" value="{{ old('key', $row->key ?? '') }}"></label>
<label>Ad <input type="text" name="name" value="{{ old('name', $row->name ?? '') }}"></label>
<label>System Prompt <textarea name="system_prompt">{{ old('system_prompt', $row->system_prompt ?? '') }}</textarea></label>
<label>User Template <textarea name="user_prompt_template">{{ old('user_prompt_template', $row->user_prompt_template ?? '') }}</textarea></label>
<label>Model <input type="text" name="model" value="{{ old('model', $row->model ?? 'gpt-4.1-mini') }}"></label>
<label>Temperature <input type="number" step="0.01" name="temperature" value="{{ old('temperature', $row->temperature ?? 0.7) }}"></label>
<label>Max Tokens <input type="number" name="max_tokens" value="{{ old('max_tokens', $row->max_tokens ?? 1200) }}"></label>
<label>Aktif
    <select name="active">
        <option value="1" @selected((string) old('active', $row->active ?? 1) === '1')>Evet</option>
        <option value="0" @selected((string) old('active', $row->active ?? 1) === '0')>Hayır</option>
    </select>
</label>
