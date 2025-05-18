<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AptitudeTestController extends Controller
{
    private $questions = [];

    public function __construct()
    {
        $this->questions = [
            1 => ['text' => 'ご職業を選んでください', 'type' => 'radio', 'options' => [
                '会社員' => '会社員', '公務員' => '公務員', '自営業' => '自営業', '大学生' => '大学生', '大学院生' => '大学院生',
            ]],
            2 => ['text' => '学部・専攻（例：工学部機械専攻）', 'type' => 'text'],
            3 => ['text' => '興味のある業種・製品', 'type' => 'radio', 'options' => [
                '機械関連' => '機械関連', '化学関連' => '化学関連', '電子部品' => '電子部品', '金属・鉄鋼関連' => '金属・鉄鋼関連',
                '食品関連' => '食品関連', '建築・住宅関連' => '建築・住宅関連', '医薬品関連' => '医薬品関連', 'その他' => 'その他',
            ]],
        ];

        $likertQuestions = [
            4 => '成長機会が多いことを大切にしたいですか？',
            5 => 'ワークライフバランスを大切にしたいですか？',
            6 => '専門性を発揮できることを重視したいですか？',
            7 => '社会や人の役に立てることを重視しますか？',
            8 => '自由な働き方を追求したいですか？',
            9 => 'チームワークを発揮して仕事をしたいですか？',
            10 => '雇用や収入の安定性を重視しますか？',
            11 => 'スピード感のある環境で働きたいですか？',
            12 => '自分のアイデアを形にしたいですか？',
            13 => '多様な人と関わる仕事がしたいですか？',
            14 => '一人で考えるのが好き（内向的）ですか？',
            15 => '探究心が強いタイプですか？',
            16 => '綿密に計画を立ててから行動するタイプですか？',
            17 => '責任感が強いタイプですか？',
            18 => '理科の実験や工作実習が面白いと感じましたか？',
            19 => '理論の授業やシミュレーションが面白いと感じましたか？',
        ];

        foreach ($likertQuestions as $step => $text) {
            $this->questions[$step] = ['text' => $text, 'type' => 'radio', 'options' => $this->likert()];
        }

        $this->questions[20] = ['text' => '留学や海外との交流経験がありますか？', 'type' => 'radio', 'options' => [
            'はい' => 'はい', 'いいえ' => 'いいえ',
        ]];

        ksort($this->questions);
    }

    public function showQuestion(Request $request)
    {
        $step = $request->input('step', 1);

        if (!isset($this->questions[$step])) {
            return redirect()->route('aptitude_test.form', ['step' => 1]);
        }

        $question = $this->questions[$step];

        return view('aptitude_test.form', [
            'currentStep' => $step,
            'totalSteps' => count($this->questions),
            'question' => $question,
            'isLast' => $step == count($this->questions),
        ]);
    }

    public function nextQuestion(Request $request)
    {
        $step = $request->input('step');
        $answer = $request->input('answer');

        Session::put("answers.q{$step}", $answer);

        return redirect()->route('aptitude_test.form', ['step' => $step + 1]);
    }

    public function submitAnswers(Request $request)
    {
        $step = $request->input('step');
        $answer = $request->input('answer');
        Session::put("answers.q{$step}", $answer);

        $answers = Session::get('answers', []);

        $inputs = [];
        foreach ($answers as $key => $val) {
            $index = str_replace('q', '', $key);
            $inputs["user_input{$index}"] = $val;
        }

        $apiKey = config('services.openai.api_key');

        $content = <<<EOT
あなたは、理工系学生及び社会人の適職診断を行うアドバイザーです。以下は、ある人が回答した内容です。選択肢は以下のように読み替えて下さい。

#とてもそう思う=5点  
#そう思う=4点  
#どちらでもない=3点  
#そう思わない=2点  
#全くそう思わない=1点

【質問と回答】
職業：{$inputs['user_input1']}
学部・専攻：{$inputs['user_input2']}
興味のある業種・製品：{$inputs['user_input3']}
成長機会：{$inputs['user_input4']}
ワークライフバランス：{$inputs['user_input5']}
専門性の発揮：{$inputs['user_input6']}
社会や人の役に立つ：{$inputs['user_input7']}
自由な働き方：{$inputs['user_input8']}
チームワークの発揮：{$inputs['user_input9']}
雇用や収入の安定性：{$inputs['user_input10']}
スピード感：{$inputs['user_input11']}
自分のアイデアを形にする：{$inputs['user_input12']}
多様な人と関わる：{$inputs['user_input13']}
一人で考えるのが好き：{$inputs['user_input14']}
探究心が強い：{$inputs['user_input15']}
計画性：{$inputs['user_input16']}
責任感：{$inputs['user_input17']}
理科の実験や工作実習が好き：{$inputs['user_input18']}
理論の授業やシミュレーションが好き：{$inputs['user_input19']}
留学・海外経験：{$inputs['user_input20']}

これらのスコアを参考に、次の10タイプのうち、最も当てはまるものを選び、理由も入れて下さい。断定的にならないように、優しく明るい口調でお願いします。スコアの点数は出力に入れないで下さい。また、診断されたタイプを参考におすすめの業種と職種を入れて下さい。

【10タイプ一覧】
1. バランス重視の探求人材  
2. 成長したい挑戦人材  
3. 創造を愛するクリエイティブ  
4. 共感型コーディネーター  
5. 安定志向のスペシャリスト  
6. 地域密着型サポーター  
7. スピード昇進ファイター  
8. こだわりが強いリサーチャー  
9. 育成志向のティーチャー  
10. 自由を愛するノマドワーカー

【業種の例】
#機械
#電子部品
#自動車
#航空宇宙

#出力形式：  
タイプ名：〇〇  
理由：〇〇〇〇  
おすすめの業種：〇〇  
おすすめの職種：〇〇

必ずこの形式で出力してください。
EOT;

        $messages = [[
            'role' => 'user',
            'content' => $content
        ]];

        $response = Http::withToken($apiKey)->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4',
            'messages' => $messages,
            'temperature' => 0.7,
        ]);

        $result = $response->json('choices.0.message.content') ?? '診断に失敗しました。';

        Session::put('aptitude_result', $result);

        preg_match('/タイプ名：(.+)/u', $result, $typeMatch);
        preg_match('/理由：(.+)/u', $result, $reasonMatch);
        preg_match('/おすすめの業種：(.+)/u', $result, $industryMatch);
        preg_match('/おすすめの職種：(.+)/u', $result, $jobMatch);

        $type = isset($typeMatch[1]) ? trim($typeMatch[1]) : '未分類';
        $reason = $reasonMatch[1] ?? '';
        $industry = $industryMatch[1] ?? '';
        $job = $jobMatch[1] ?? '';

        $imageMap = [
            'バランス重視の探求人材' => 'result1.png',
            '成長したい挑戦人材' => 'result2.png',
            '創造を愛するクリエイティブ' => 'result3.png',
            '共感型コーディネーター' => 'result4.png',
            '安定志向のスペシャリスト' => 'result5.png',
            '地域密着型サポーター' => 'result6.png',
            'スピード昇進ファイター' => 'result7.png',
            'こだわりが強いリサーチャー' => 'result8.png',
            '育成志向のティーチャー' => 'result9.png',
            '自由を愛するノマドワーカー' => 'result10.png',
        ];

        $imageFile = $imageMap[$type] ?? 'default.png';

        return view('aptitude_test.result', compact('result', 'type', 'reason', 'industry', 'job', 'imageFile'));
    }

    private function likert()
    {
        return [
            'とてもそう思う' => 'とてもそう思う',
            'そう思う' => 'そう思う',
            'どちらでもない' => 'どちらでもない',
            'そう思わない' => 'そう思わない',
            '全くそう思わない' => '全くそう思わない',
        ];
    }
}
