<?php
namespace CMSLite;

use CMSLite\Database;
use CMSLite\User;

class Posts{

    public static function newPost($category, $title, $content, $id = 0){
        $conn = new Database();

        //Update post
        if($id !== 0){
            $update = $conn->count("UPDATE ".ACCOUNT_DB.".cmsnews SET category = :CATEGORY, title = :TITLE, content = :CONTENT WHERE id = :ID", [
                ":CATEGORY" => $category,
                ":TITLE" => $title,
                ":CONTENT" => $content,
                ":ID" => $id
            ]);
    
            if($update > 0){
                User::setMsg([Translate::text('success_update_post'), 'success']);
                return true;
            }else{
                User::setMsg([Translate::text('failed_update_post'), 'failed']);
                return false;
            }
        }

        $result = $conn->count("INSERT INTO ".ACCOUNT_DB.".cmsnews (category, title, content, date, author) VALUES (:CATEGORY, :TITLE, :CONTENT, NOW(), :AUTHOR)", [
            ":CATEGORY" => $category,
            ":TITLE" => $title,
            ":CONTENT" => $content,
            ":AUTHOR" => $_SESSION['username']
        ]);

        if($result > 0){
            return true;
        }

        User::setMsg([Translate::text('error_insert_new_post'), 'failed']);
        return false;

    }

    public static function getPosts($limit = 100){
        $conn = new Database();

        $result = $conn->select("SELECT * FROM ".ACCOUNT_DB.".cmsnews WHERE deleted = 0 ORDER BY id DESC LIMIT :LIMIT",[
            ":LIMIT" => $limit
        ]);

        if(count($result) > 0){
            return $result;
        }

        User::setMsg([Translate::text('not_posts_found'), 'failed']);
        return false;

    }

    public static function showPost($id){
        $conn = new Database();

        $result = $conn->select("SELECT id, category, title, content, date FROM ".ACCOUNT_DB.".cmsnews WHERE id = :ID", [
            ":ID" => $id
        ]);

        if(count($result) > 0){
            return $result[0];
        }

        return false;

    }

    public static function deletePost($id){
        $conn = new Database();

        $result = $conn->count("UPDATE ".ACCOUNT_DB.".cmsnews SET deleted = 1 WHERE id = :ID",[
            ":ID" => $id
        ]);

        if($result > 0){
            User::setMsg([Translate::text('post_deleted'), 'success']);
            return true;
        }
        
        User::setMsg([Translate::text('err_post_delete'), 'failed']);
        return false;
    }


}