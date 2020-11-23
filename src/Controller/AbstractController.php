<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 15:38
 * PHP version 7
 */

namespace App\Controller;

use App\Model\UserManager;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 *
 */
abstract class AbstractController
{
    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var array|null
     */
    private $user = null;

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => !APP_DEV,
                'debug' => APP_DEV,
            ]
        );
        $this->twig->addExtension(new DebugExtension());

        if (isset($_SESSION['user']['email']) && !empty($_SESSION['user']['email'])) {
            // Recup mon user connecte depuis la DB via son email
            $userManager = new UserManager();
            $user = $userManager->selectUserByEmail($_SESSION['user']['email']);
            // Stocke mon user dans ma propriete privee $user
            $this->user = $user;
        }

        $this->twig->addGlobal('app', [
            "session" => $_SESSION,
            "user" => $this->user,
        ]);
    }

    protected function getUser(): array
    {
        return $this->user;
    }
}
