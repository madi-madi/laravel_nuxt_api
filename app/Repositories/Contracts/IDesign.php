<?php
namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface IDesign
{
   // public function all();
   // public function allLive();
   public function applyTags($id , $data);
   public function addComment($designId ,array $data);
   public function like($id);
   public function isLikedByUser($id);
   public function search(Request $request);


}