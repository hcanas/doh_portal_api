<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IDCardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
    public function __invoke(User $user)
    {
        if ($user === null) {
            return response()->json('User not found.', 404);
        }
        
        $this->generateRegularID($user);
        $this->generateJCID($user);
        
        return response()->json([
            'jc_front' => 'jc_a_'.$user->id.'.png',
            'jc_back' => 'jc_b_'.$user->id.'.png',
            'reg_front' => 'reg_a_'.$user->id.'.png',
            'reg_back' => 'reg_b_'.$user->id.'.png',
        ]);
    }
    
    private function generateRegularID($user)
    {
        $template_front = Image::make(Storage::get('public/templates/reg_front.png'));
        
        $avatar_reshape = Image::canvas(400, 400);
        $avatar_reshape->circle(400, 200, 200, function ($draw) {
            $draw->background('#ffffff');
        });
        
        $avatar = Image::make(Storage::get('public/photos/'.($user->avatar ?? 'placeholder.png')));
        $avatar->resize(399, 399);
        $avatar->mask($avatar_reshape->encode('png'), true);
        
        $template_front->insert($avatar->encode(), 'center', -481, 111);
        
        $template_front->text(strtoupper($user->name), 1000, 500, function ($font) use ($user) {
            $font->file(public_path('fonts/Matter/Matter-Bold.otf'));
            $font->size(80 - strlen($user->name));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text(wordwrap(strtoupper($user->position), 50), 1000, 550, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(40);
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text(strtoupper($user->code), 280, 850, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(40);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text(strtoupper($user->address), 680, 700, function ($font) use ($user) {
            $font_size = strlen($user->address) > 28
                ? 36 - ((strlen($user->address) - 28) * 0.5)
                : 36;
            
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size($font_size);
            $font->color('#ffffff');
            $font->align('left');
            $font->valign('center');
        });
        
        $template_front->text(strtoupper($user->contact_number), 680, 770, function ($font) use ($user) {
            $font_size = strlen($user->contact_number) > 28
                ? 36 - ((strlen($user->contact_number) - 28) * 0.5)
                : 36;
            
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size($font_size);
            $font->color('#ffffff');
            $font->align('left');
            $font->valign('center');
        });
        
        $template_front->text(strtoupper($user->email ?? ''), 680, 850, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size(36);
            $font->color('#ffffff');
            $font->align('left');
            $font->valign('center');
        });
        
        $template_back = Image::make(Storage::get('public/templates/reg_back.png'));
        
        $birthdate = $user->birthdate ? date('m/d/Y', strtotime($user->birthdate)) : '';
        $template_back->text(strtoupper($birthdate), 700, 88, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(36);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
        
        $template_back->text(strtoupper($user->sex ?? ''), 700, 168, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(36);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
        
        $template_back->text(strtoupper($user->blood_type ?? ''), 700, 248, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(36);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
        
        $template_back->text(strtoupper($user->gsis_number ?? ''), 700, 360, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(36);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
        
        $template_back->text(strtoupper($user->pagibig_number ?? ''), 700, 440, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(36);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
        
        $template_back->text(strtoupper($user->philhealth_number ?? ''), 700, 520, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(36);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
        
        $template_back->text(strtoupper($user->tin_number ?? ''), 700, 600, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(36);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
        
        $template_back->text(strtoupper($user->emergency_contact_name ?? ''), 700, 790, function ($font) use ($user) {
            $font_size = strlen($user->emergency_contact_name) > 18
                ? 34 - ((strlen($user->emergency_contact_name) - 18) * 0.5)
                : 34;
            
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size($font_size);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
        
        $template_back->text(strtoupper($user->emergency_contact_number ?? ''), 700, 863, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(36);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
        
        $qrcode = Image::make(base64_encode(QrCode::format('png')
            ->size(265)
            ->color(11, 63, 41)
            ->margin(1)
            ->encoding('UTF-8')
            ->merge('/public/logos/doh.png')
            ->generate(env('VERIFICATION_DOMAIN').'/'.Crypt::encryptString($user->code))
        ));
        
        $qr_border = Image::canvas(280, 280, '#0b3f29');
        
        $template_back->insert($qr_border->encode(), 'center', 355, 80);
        $template_back->insert($qrcode->encode(), 'center', 355, 80);
        
        Storage::put('public/cards/reg_a_'.($user->id ?? 'placeholder').'.png', (string) $template_front->encode());
        Storage::put('public/cards/reg_b_'.($user->id ?? 'placeholder').'.png', (string) $template_back->encode());
    }
    
    private function generateJCID($user)
    {
        $template_front = Image::make(Storage::get('public/templates/jc_front.png'));
        
        $avatar = Image::make(Storage::get('public/photos/'.($user->avatar ?? 'placeholder.png')));
        $avatar->resize(699, 699);
        
        $template_front->insert($avatar->encode(), 'center', -245, -230);
        
        $template_front_2 = Image::make(Storage::get('public/templates/jc_front_2.png'));
        $template_front->insert($template_front_2->encode(), 'center', 0, 0);
        
        // nickname
        $nickname = $user->nickname ?? explode(' ', $user->name)[1];
        
        $template_front->text(strtoupper($nickname), 1140, 607, function ($font) use ($nickname) {
            $font->file(public_path('fonts/Matter/Matter-HeavyItalic.otf'));
            $font->size(100 - strlen($nickname));
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
        
        $template_front->text(strtoupper($nickname), 1140, 600, function ($font) use ($nickname) {
            $font->file(public_path('fonts/Matter/Matter-HeavyItalic.otf'));
            $font->size(100 - strlen($nickname));
            $font->color('#80c892');
            $font->align('right');
            $font->valign('center');
        });
        
        $template_front->text(strtoupper($user->name), 625, 1139, function ($font) use ($user) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(92 - strlen($user->name));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text(strtoupper($user->name), 625, 1141, function ($font) use ($user) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(92 - strlen($user->name));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text(strtoupper($user->name), 624, 1140, function ($font) use ($user) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(92 - strlen($user->name));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text(strtoupper($user->name), 626, 1140, function ($font) use ($user) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(92 - strlen($user->name));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text(strtoupper($user->name), 625, 1147, function ($font) use ($user) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(92 - strlen($user->name));
            $font->color('#008e4d');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text(strtoupper($user->name), 625, 1140, function ($font) use ($user) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(92 - strlen($user->name));
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('center');
        });
        
        // position
        $template_front->text($user->position, 625, 1219, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(40);
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text($user->position, 625, 1221, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(40);
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text($user->position, 624, 1220, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(40);
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text($user->position, 626, 1224, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(40);
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text($user->position, 625, 1220, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(40);
            $font->color('#008e4d');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text($user->position, 625, 1220, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(40);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('center');
        });
        
        // id number
        $template_front->text(strtoupper($user->code ?? ''), 625, 1690, function ($font) use ($user) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(60 - strlen($user->code));
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_back = Image::make(Storage::get('public/templates/jc_back.png'));
        
        $qrcode = Image::make(base64_encode(QrCode::format('png')
            ->size(250)
            ->color(41, 142, 103)
            ->margin(1)
            ->encoding('UTF-8')
            ->merge('/public/logos/doh.png')
            ->generate(env('VERIFICATION_DOMAIN').'/'.Crypt::encryptString($user->code))
        ));
        
        $qr_border = Image::canvas(260, 260, '#298e67');
        
        $template_back->insert($qr_border->encode('png'), 'center', 395, 682);
        $template_back->insert($qrcode->encode(), 'center', 395, 682);
        
        Storage::put('public/cards/jc_a_'.($user->id ?? 'placeholder').'.png', (string) $template_front->encode());
        Storage::put('public/cards/jc_b_'.($user->id ?? 'placeholder').'.png', (string) $template_back->encode());
    }
}
