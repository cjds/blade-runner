<?php

class PostSeeder extends Seeder {

	public function run()
    {

        Tag::create(
            array(
                'tags_id'=>1,
                'tag_name'=>'physics',
                'tag_description'=>'The physical science'
            )
        );

        Tag::create(
            array(
            'tags_id'=>2,
            'tag_name'=>'universe',
            'tag_description'=>'The entire one'  
            )
        );

        Post::create(
    		array(
    			'post_id'=>1,
				'post_type'=>'Question',
				'creator_id'=>1
			)
        );

        Post::create(
            array(
                'post_id'=>2,
                'post_type'=>'Answer',
                'creator_id'=>3          
            )
        );

        Post::create(        
            array(
                'post_id'=>3,
                'post_type'=>'Answer',
                'creator_id'=>2
            )
        );


        Question::create(
        		array(
					'post_id'=>1,
					'question_title'=>'What is the sun?',
					'question_body'=>'Is it a star or what?'
				)
        );

        Question::find(1)->tags()->attach(1);
        Question::find(1)->tags()->attach(2);        

  
        Answer::create(
    		array(
				'post_id'=>2,
				'answer_body'=>'A star',
				'answer_question_id'=>1
	       )
        );

        Answer::create(
    		array(
				'post_id'=>3,
				'answer_body'=>'Star',
				'answer_question_id'=>1
			)
        );
    }
}
?>