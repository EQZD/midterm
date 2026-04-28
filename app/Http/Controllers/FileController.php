<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Загрузить файл для члена клуба
     * Доступно: super_admin, manager, staff
     */
    public function store(Request $request, Member $member)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240',                          // макс 10 MB
                'mimes:jpg,jpeg,png,pdf,doc,docx',    // разрешённые типы
            ],
        ]);

        $uploadedFile = $request->file('file');

        // Уникальное имя чтобы не было конфликтов
        $storedName = Str::uuid() . '.' . $uploadedFile->getClientOriginalExtension();

        // Сохраняем в storage/app/private/member-files/
        $path = $uploadedFile->storeAs('member-files', $storedName, 'private');

        // Записываем в БД
        MemberFile::create([
            'member_id'     => $member->id,
            'original_name' => $uploadedFile->getClientOriginalName(),
            'stored_name'   => $storedName,
            'file_path'     => $path,
            'mime_type'     => $uploadedFile->getMimeType(),
            'file_size'     => $uploadedFile->getSize(),
            'uploaded_by'   => Auth::user()->email,
        ]);

        return back()->with('success', 'File "' . $uploadedFile->getClientOriginalName() . '" uploaded successfully.');
    }

    /**
     * Скачать файл (только авторизованные)
     */
    public function download(MemberFile $file)
    {
        // Проверяем что файл физически существует
        if (!Storage::disk('private')->exists($file->file_path)) {
            abort(404, 'File not found on disk.');
        }

        return Storage::disk('private')->download(
            $file->file_path,
            $file->original_name
        );
    }

    /**
     * Удалить файл
     * Доступно: super_admin, manager
     */
    public function destroy(MemberFile $file)
    {
        // Удаляем физический файл
        Storage::disk('private')->delete($file->file_path);

        // Удаляем запись из БД
        $file->delete();

        return back()->with('success', 'File deleted successfully.');
    }
}
