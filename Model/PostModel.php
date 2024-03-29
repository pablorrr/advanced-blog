<?php
namespace Model;

use PDO;

/**
 * Class PostModel
 * @package Model
 */
class PostModel extends MainModel
{
    /**
     * @var PDO
     */
    protected PDO $oDb;
    /**
     * @var CommentModel
     */
    protected CommentModel $CommentModel;

    /**
     * PostModel constructor.
     * @param CommentModel $CommentModel
     */
    public function __construct(CommentModel $CommentModel)
    {
        $this->oDb = MainModel::getInstance()->getConnection();
        $this->CommentModel = $CommentModel;
    }

    /**
     * @param $iOffset
     * @param $iLimit
     * @return array
     *
     */
    public function get($iOffset, $iLimit)
    {
        if ($this->CommentModel->get() == false) {

            $oStmt = $this->oDb->prepare('SELECT * FROM Posts ORDER BY createdDate DESC LIMIT :offset, :limit');
            $oStmt->bindParam(':offset', $iOffset, \PDO::PARAM_INT);
            $oStmt->bindParam(':limit', $iLimit, \PDO::PARAM_INT);
            $oStmt->execute();
            return $oStmt->fetchAll(\PDO::FETCH_OBJ);

        }
        if ($this->CommentModel->get() == true) {

            $oStmt = $this->oDb->prepare('SELECT posts.id, posts.title, posts.body,posts.createdDate, comments.comment
      FROM comments
       RIGHT JOIN posts ON comments.post_id = posts.id  ORDER BY createdDate DESC LIMIT :offset, :limit');
            $oStmt->bindParam(':offset', $iOffset, \PDO::PARAM_INT);
            $oStmt->bindParam(':limit', $iLimit, \PDO::PARAM_INT);
            $oStmt->execute();
            return $oStmt->fetchAll(\PDO::FETCH_OBJ);
        }

    }

    /**
     *
     * @return array
     */
    public function getAll()
    {
        if ($this->CommentModel->get() == false) {
            $oStmt = $this->oDb->query('SELECT * FROM Posts ORDER BY createdDate DESC');
            return $oStmt->fetchAll(\PDO::FETCH_OBJ);
        }
        if ($this->CommentModel->get() == true) {

            $oStmt = $this->oDb->query('SELECT posts.id, posts.title, posts.body,posts.createdDate, comments.comment
       FROM comments
       RIGHT JOIN posts ON comments.post_id = posts.id  ORDER BY createdDate');
            return $oStmt->fetchAll(\PDO::FETCH_OBJ);
        }
    }

    /**
     *
     * @param array $aData
     * @return bool
     */
    public function add(array $aData)
    {
        $oStmt = $this->oDb->prepare('INSERT INTO Posts (title, body, createdDate) VALUES(:title, :body, :created_date)');
        return $oStmt->execute($aData);
    }

    /**
     *
     * @param $iId
     * @return mixed
     */
    public function getById($iId)
    {
        if ($this->CommentModel->getById($iId) == false) {

            $oStmt = $this->oDb->prepare('SELECT * FROM Posts WHERE id = :postId LIMIT 1');
            $oStmt->bindParam(':postId', $iId, \PDO::PARAM_INT);
            $oStmt->execute();
            return $oStmt->fetch(\PDO::FETCH_OBJ);

        } elseif ($this->CommentModel->get() == true) {
            $oStmt = $this->oDb->prepare('SELECT posts.id, posts.title, posts.body,posts.createdDate, comments.comment FROM posts,comments
WHERE posts.id= :postId AND comments.post_id= :postId');
            $oStmt->bindParam(':postId', $iId, \PDO::PARAM_INT);
            $oStmt->execute();
            return $oStmt->fetch(\PDO::FETCH_OBJ);
        }

    }

    /**
     * @param array $aData
     * @return bool
     */
    public function update(array $aData)
    {
        $oStmt = $this->oDb->prepare('UPDATE Posts SET title = :title, body = :body WHERE id = :postId LIMIT 1');
        $oStmt->bindValue(':postId', $aData['post_id'], \PDO::PARAM_INT);
        $oStmt->bindValue(':title', $aData['title']);
        $oStmt->bindValue(':body', $aData['body']);
        return $oStmt->execute();
    }

    /**
     *
     * @param $iId
     * @return bool
     */
    public function delete($iId)
    {
        $oStmt = $this->oDb->prepare('DELETE FROM Posts WHERE id = :postId LIMIT 1');
        $oStmt->bindParam(':postId', $iId, \PDO::PARAM_INT);
        return $oStmt->execute();
    }
}
