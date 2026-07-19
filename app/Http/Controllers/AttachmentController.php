<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class AttachmentController extends Controller
{
    /**
     * Upload an attachment
     */
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'file' => 'required|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx'
        ]);

        if (!$request->hasFile('file')) {
            return back()->with('error', 'No file selected.');
        }

        $file = $request->file('file');

        $path = $file->store('attachments', 'public');

        $attachment = Attachment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'filename' => $file->getClientOriginalName(),
            'filepath' => $path,
            'filetype' => $file->getMimeType(),
            'filesize' => $file->getSize(),
        ]);

        return back()->with('success', 'File uploaded successfully. Attachment ID: '.$attachment->id);
    }

    /**
     * Download an attachment
     */
    public function download(Attachment $attachment)
    {
        if (!Storage::disk('public')->exists($attachment->filepath)) {
            abort(404, 'File not found.');
        }

        $path = Storage::disk('public')->path($attachment->filepath);

        return response()->download($path, $attachment->filename);
    }

    /**
     * Delete an attachment
     */
    public function destroy(Attachment $attachment)
    {
        if (Storage::disk('public')->exists($attachment->filepath)) {
            Storage::disk('public')->delete($attachment->filepath);
        }

        $attachment->delete();

        return back()->with('success', 'Attachment deleted successfully.');
    }
}