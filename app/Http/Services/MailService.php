<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Support\Facades\Mail;

/**
 * 功能：邮件服务层
 *
 * @author: stevenv
 * @date: 2021-10-12
 **/
class MailService
{

    /**
     * 功能：发送文本邮件
     *
     * @author: stevenv
     * @date  : 2021-10-12
     * @param string $subject
     * @param string $content
     * @param string $from
     * @param string $to
     * @param string $fromName
     */
    public function sendText(string $subject, string $content, string $from, string $to, string $fromName) {
        try {
            Mail::raw($content,function ($message) use($to, $fromName, $from, $subject) {
                // 发件人（你自己的邮箱和名称）
                $message->from($from, $fromName);
                // 收件人的邮箱地址
                $message->to($to);
                // 邮件主题
                $message->subject($subject);
            });
            return true;
        } catch (Exception $e) {
            app('log')->error("发送邮件失败,原因：" . $e->getMessage(), ['params' => func_get_args()]);
            return false;
        }
    }
}