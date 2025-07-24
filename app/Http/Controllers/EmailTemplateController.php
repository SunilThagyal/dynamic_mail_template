<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->is_admin) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $templates = EmailTemplate::all();
        return view('email_templates.index', compact('templates'));
    }

    public function create()
    {
        return view('email_templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:email_templates,name',
            'subject' => 'required',
            'content' => 'required',
        ]);

        EmailTemplate::create($request->all());
        return redirect()->route('email_templates.index')->with('success', 'Template created successfully.');
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        return view('email_templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $request->validate([
            'name' => 'required|unique:email_templates,name,' . $emailTemplate->id,
            'subject' => 'required',
            'content' => 'required',
        ]);

        $emailTemplate->update($request->all());
        return redirect()->route('email_templates.index')->with('success', 'Template updated successfully.');
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();
        return redirect()->route('email_templates.index')->with('success', 'Template deleted successfully.');
    }

    public function sendDummy(EmailTemplate $template)
    {
        $user = User::where('is_admin', false)->first();

        if (!$user) {
            return back()->with('error', 'No non-admin user found.');
        }

        $placeholders = [
            'name' => $user->name,
            'email' => $user->email,
            'website_url' => 'https://yourwebsite.com',
            'current_date' => now()->format('F j, Y'),
        ];

        $content = $this->replacePlaceholders($template->content, $placeholders);
        $subject = $this->replacePlaceholders($template->subject, $placeholders);

        Mail::send([], [], function ($message) use ($user, $subject, $content) {
            $message->to($user->email)
                    ->subject($subject)
                    ->html($content);
        });

        return back()->with('success', 'Dummy email sent to ' . $user->email);
    }



    protected function replacePlaceholders($content, $data = [])
    {
        foreach ($data as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }

        return $content;
    }

}
