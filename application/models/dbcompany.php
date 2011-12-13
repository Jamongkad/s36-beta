<?php

class DBCompany extends S36DataObject {
    public function update_company_emails($post) {
        DB::Table('Company', 'master') 
            ->where('companyId', '=', $post->companyid)
            ->update(Array(
                'ffEmail1' => $post->ffEmail1
              , 'ffEmail2' => $post->ffEmail2
              , 'ffEmail3' => $post->ffEmail3
              , 'alias1' => $post->alias1
              , 'alias2' => $post->alias2
              , 'alias3' => $post->alias3
              , 'replyTo' => $post->replyTo
            ));
    }
}
