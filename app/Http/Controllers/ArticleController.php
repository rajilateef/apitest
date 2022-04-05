<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *      path="/articles",
     *      operationId="getProjectsList",
     *      summary="Get list of articles",
     *      description="Returns list of artiscles",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="$/components/schemas/Article")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *      ),
     *     )
     */
    public function getArticles(){
        $articles = Post::orderBy('id', 'desc')->paginate(10);
        if(!$articles){
            return response()->json(['message' => 'No articles found'], 404);
        }
        return response()->json($articles, 200);
    }


    /**
     * @OA\Post(
     ** path="/api/user-register",
     *   tags={"Register"},
     *   summary="Register",
     *   operationId="register",
     *
     *  @OA\Parameter(
     *      name="cover",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *
     *  @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *
     *  @OA\Parameter(
     *      name="body",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *
     *
     *     *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"body","title", "cover", ""},
        *               @OA\Property(property="body", type="text"),
        *               @OA\Property(property="title", type="text"),
        *               @OA\Property(property="cover", type="text"),
        *         )
        *            ),
        *        ),
        *    ),

     * @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     * @OA\Response(
     *      response=422,
     *      description="Validation failed",
     *   ),
     *
    **/

    public function createArticle(Request $request){
        $this->validate($request, [
            'cover' => 'required',
            'title' => 'required',
            'body' => 'required'
        ]);

        if($request->fail){
            return response()->json(['message' => 'Validation failed'], 422);
        }
        $article = Post::create($request->all());
        return response()->json($article, 201);
    }
    /**
 * @OA\Get(
 * path="/api/articles/{id}",
 * summary="Get article Details",
 * description="Get article Details",
 * operationId="GetArticleDetails",
 * tags={"ArticleDetails"},
 * security={ {"bearer": {} }},
 * @OA\Parameter(
 *    description="ID of Post",
 *    in="path",
 *    name="userId",
 *    required=true,
 *    example="1",
 *    @OA\Schema(
 *       type="integer",
 *       format="int64"
 *    )
 * )
 * )
 */

    public function getArticle($id){
        $article = Post::findorfail($id);
        if(!$article){
            return response()->json(['message' => 'No article found'], 404);
        }
        return response()->json($article, 200);
    }


    public function updateArticle($id, Request $request){
        $article = Post::findorfail($id);
        if(!$article){
            return response()->json(['message' => 'No article found'], 404);
        }
        $article->update($request->all());
        return response()->json($article, 200);
    }


        /**
 * @OA\Get(
 * path="/api/articles/{id}/view",
 * summary="Get article Details",
 * description="Get article Details",
 * operationId="GetArticleDetails",
 * tags={"ArticleDetails"},
 * security={ {"bearer": {} }},
 * @OA\Parameter(
 *    description="ID of Post",
 *    in="path",
 *    name="userId",
 *    required=true,
 *    example="1",
 *    @OA\Schema(
 *       type="integer",
 *       format="int64"
 *    )
 * )
 * )
 */
    public function showCount($id){
        $article = Post::findorfail($id);
        if(!$article){
            return response()->json(['message' => 'No article found'], 404);
        }
        $article->views_count = $article->views_count + 1;
        $article->save();
        return response()->json(['view_count'=>$article->views_count], 200);
    }


    public function showViewCount($id){
        $article = Post::findorfail($id);
        if(!$article){
            return response()->json(['message' => 'No article found'], 404);
        }
        return response()->json($article->view_count, 200);
    }


    public function deleteArticle($id){
        $article = Post::findorfail($id);
        if(!$article){
            return response()->json(['message' => 'No article found'], 404);
        }
        $article->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Post(
     ** path="/api/user-register",
     *   tags={"Register"},
     *   summary="Register",
     *   operationId="register",
     *
     *  @OA\Parameter(
     *      name="action",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *
     *  @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *
     *  @OA\Parameter(
     *      name="body",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      ),
     *
     * * @OA\Response(
     *      response=201,
     *       description="Success",
     * like_count=$likeCount,
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     
     * **/

    public function likeArticle(Request $request, $id){
        $action = strtolower($request->get('action'));
        switch($action){
            case 'like' :
                Post::where('id', $id)->increment('likes_count');
                break;
            case 'unlike' :
                Post::where('id', $id)->decrement('likes_count');
                break;
        }
    $likeCount = Post::find($id)->likes_count;
        return response()->json(['likes_count' => $likeCount], 200);
    }

}
