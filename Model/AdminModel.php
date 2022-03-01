<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */

namespace Model;

class AdminModel extends MainModel
{
    /**
     * @var \PDO
     */
    protected $oDb;

    /**
     * Admin constructor.
     */
    public function __construct()
    {
        $this->oDb = MainModel::getInstance()->getConnection();
    }

    /**
     * @param $sEmail
     * @return mixed
     */
    public function login($sEmail)
    {
        $oStmt = $this->oDb->prepare('SELECT email, password FROM Admins WHERE email = :email LIMIT 1');
        $oStmt->bindValue(':email', $sEmail, \PDO::PARAM_STR);
        $oStmt->execute();
        $oRow = $oStmt->fetch(\PDO::FETCH_OBJ);

        return @$oRow->password;
    }

    /**
     * @param array $Data
     * @return bool
     */
    public function register(array $Data)
    {
        $oStmt = $this->oDb->prepare('INSERT INTO Admins ( email,password) VALUES( :email, :password)');
        return $oStmt->execute($Data);
    }

    /**
     * @return array
     *  to check if given email exists  do not replicate user with same email in DB
     */
    public function getAllEmails()
    {
        $oStmt = $this->oDb->prepare('SELECT email FROM Admins');
        $oStmt->execute();
        return $oStmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getEmailById($iId)
    {
        $oStmt = $this->oDb->prepare('SELECT email FROM Admins WHERE id = :id LIMIT 1');
        $oStmt->bindParam(':id', $iId, \PDO::PARAM_INT);
        $oStmt->execute();
        return $oStmt->fetch(\PDO::FETCH_OBJ);

    }


    /**
     * @param array $aData
     * @return bool
     */
    public function update(array $aData)
    {
        $oStmt = $this->oDb->prepare('UPDATE Admins SET email = :email, password = :password WHERE id = :id LIMIT 1');
        $oStmt->bindValue(':id', $aData['id'], \PDO::PARAM_INT);
        $oStmt->bindValue(':email', $aData['email']);
        $oStmt->bindValue(':password', $aData['password']);
        return $oStmt->execute();
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $oStmt = $this->oDb->query('SELECT * FROM Admins ORDER BY id ASC');
        return $oStmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * @param $iId
     * @return mixed
     */
    public function getById($iId)
    {
        $oStmt = $this->oDb->prepare('SELECT * FROM Admins WHERE id = :id LIMIT 1');
        $oStmt->bindParam(':id', $iId, \PDO::PARAM_INT);
        $oStmt->execute();
        return $oStmt->fetch(\PDO::FETCH_OBJ);

    }

    /**
     * @return mixed
     */

    public function countAdmins()
    {
        $oStmt = $this->oDb->prepare('SELECT count(*) FROM Admins');
        $oStmt->execute();
        return $oStmt->fetchColumn();
    }

    /**
     * @param $id
     * @return bool
     */

    /**
     * @param $id
     * @return bool
     *

     */

    public function delete($id)
    {
        $oStmt = $this->oDb->prepare('DELETE FROM Admins WHERE id = :id LIMIT 1');
        $oStmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $oStmt->execute();
    }
}
