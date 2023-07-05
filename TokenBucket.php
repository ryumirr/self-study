<?php

/**
 * コンストラクタで、bucket設定
 *
 * (1)トークンがあれば、リクエスト通れるw
 * (2)なかったらdropped
 */
class TokenBucket
{
    private const MIN_AVAILABLE_TOKEN = 2;
    private int $availableToken;
    private int $maxBucketSize;
    private int $refillRate;

    /**
     * コンストラクタ
     *
     * @param int $maxBucketSize バケットに入れるトークンの最大数
     * @param int $refillRate （単位：1秒）バケットにrefillされるトークンの数
     */
    public function __construct(int $maxBucketSize, int $refillRate)
    {
        $this->availableToken = $maxBucketSize;
        $this->maxBucketSize = $maxBucketSize;
        $this->refillRate = $refillRate;
    }

    /**
     * consumeToken(１リクエスト１トークン使用)
     *
     * @return void
     */
    public function consumeToken(): void
    {
        if (!$this->checkToken()) {
            $this->dropRequest();
        }
        $this->availableToken -= 1;
    }
    /**
     * トークンチェック。
     * 念の為(?)最低のトークンがある場合のみ、トークンを捨てるようにしました。
     *
     * @return boolean
     */
    private function checkToken(): bool
    {
        //　任意で最低２に決めうちw
        if ($this->availableToken > self::MIN_AVAILABLE_TOKEN) {
            return true;
        }
        return false;
    }
    /**
     * リクエスト終了
     *
     * @return void
     */
    private function dropRequest(): void
    {
        header("HTTP/1.1 429 Too Many Requests");
        exit;
    }
    /**
     * トークンリフィル
     *
     * @return boolean
     */
    public function refillTokens(): bool
    {
        if (!$this->checkTokenForRefill()) {
            return false;
        }
        // refill実行
        $this->availableToken += $this->refillRate;
        return true;
    }
    /**
     * (asyncしたいけど、phpではできないのでw Curlオプションでします)
     * Refillするため、チェック。
     *
     * @return bool
     */
    private function checkTokenForRefill(): bool
    {
        return ($this->availableToken - $this->refillRate) < $this->maxBucketSize;
    }
}
