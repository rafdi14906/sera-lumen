<?php

class BlogTest extends TestCase
{
    public function testBlogResponseStatus()
    {
        $response = $this->call('GET', '/blog');

        $this->assertEquals(200, $response->status());
    }

    public function testBlogPost()
    {
        $now = date('Y-m-d h:i:s');
        $data = [
            'title' => 'Judul Artikel',
            'content' => 'Konten Artiker',
            'created_at' => $now,
            'updated_at' => $now,
        ];
        $this->post('/blog', $data)
             ->seeJsonStructure([
                'status',
                'message',
                'total_data',
                'data'
             ])
             ->seeStatusCode(200);
    }

    public function testBlogShow()
    {
        $this->get('/blog/6234b157b1700000880028e3')
             ->seeJson(['status' => 1])
             ->seeStatusCode(200);
    }

    public function testBlogDelete()
    {
        $now = date('Y-m-d h:i:s');
        $data = [
            'title' => 'Judul Artikel',
            'content' => 'Konten Artiker',
            'created_at' => $now,
            'updated_at' => $now,
        ];
        $this->post('/blog', $data)
             ->seeStatusCode(200);
    }
}
