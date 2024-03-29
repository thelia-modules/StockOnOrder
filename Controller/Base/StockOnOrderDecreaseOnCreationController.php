<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace StockOnOrder\Controller\Base;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Controller\Admin\AbstractCrudController;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Template\ParserContext;
use Thelia\Tools\URL;
use StockOnOrder\Event\StockOnOrderDecreaseOnCreationEvent;
use StockOnOrder\Event\StockOnOrderDecreaseOnCreationEvents;
use StockOnOrder\Model\StockOnOrderDecreaseOnCreationQuery;

/**
 * Class StockOnOrderDecreaseOnCreationController
 * @package StockOnOrder\Controller\Base
 * @author TheliaStudio
 */
class StockOnOrderDecreaseOnCreationController extends AbstractCrudController
{
    protected RequestStack $requestStack;
    protected ParserContext $parserContext;

    public function __construct(RequestStack $requestStack, ParserContext $parserContext)
    {
        $this->requestStack = $requestStack;
        $this->parserContext = $parserContext;

        parent::__construct(
            "stock_on_order_decrease_on_creation",
            "id",
            "order",
            AdminResources::MODULE,
            StockOnOrderDecreaseOnCreationEvents::CREATE,
            StockOnOrderDecreaseOnCreationEvents::UPDATE,
            StockOnOrderDecreaseOnCreationEvents::DELETE,
            null,
            null,
            "StockOnOrder"
        );
    }

    /**
     * Return the creation form for this object
     */
    protected function getCreationForm()
    {
        return $this->createForm("stock_on_order_decrease_on_creation.create");
    }

    /**
     * Return the update form for this object
     */
    protected function getUpdateForm($data = array())
    {
        if (!is_array($data)) {
            $data = array();
        }

        return $this->createForm("stock_on_order_decrease_on_creation.update", "form", $data);
    }

    /**
     * Hydrate the update form for this object, before passing it to the update template
     *
     * @param mixed $object
     */
    protected function hydrateObjectForm(ParserContext $parserContext, $object)
    {
        $data = array(
            "id" => $object->getId(),
            "module_id" => $object->getModuleId(),
            "decrease_on_order_creation" => (bool) $object->getDecreaseOnOrderCreation(),
        );

        return $this->getUpdateForm($data);
    }

    /**
     * Creates the creation event with the provided form data
     *
     * @param mixed $formData
     * @return \Thelia\Core\Event\ActionEvent
     */
    protected function getCreationEvent($formData)
    {
        $event = new StockOnOrderDecreaseOnCreationEvent();

        $event->setModuleId($formData["module_id"]);
        $event->setDecreaseOnOrderCreation($formData["decrease_on_order_creation"]);

        return $event;
    }

    /**
     * Creates the update event with the provided form data
     *
     * @param mixed $formData
     * @return \Thelia\Core\Event\ActionEvent
     */
    protected function getUpdateEvent($formData)
    {
        $event = new StockOnOrderDecreaseOnCreationEvent();

        $event->setId($formData["id"]);
        $event->setModuleId($formData["module_id"]);
        $event->setDecreaseOnOrderCreation($formData["decrease_on_order_creation"]);

        return $event;
    }

    /**
     * Creates the delete event with the provided form data
     */
    protected function getDeleteEvent()
    {
        $event = new StockOnOrderDecreaseOnCreationEvent();

        $event->setId($this->requestStack->getCurrentRequest()->request->get("stock_on_order_decrease_on_creation_id"));

        return $event;
    }

    /**
     * Return true if the event contains the object, e.g. the action has updated the object in the event.
     *
     * @param mixed $event
     */
    protected function eventContainsObject($event)
    {
        return null !== $this->getObjectFromEvent($event);
    }

    /**
     * Get the created object from an event.
     *
     * @param mixed $event
     */
    protected function getObjectFromEvent($event)
    {
        return $event->getStockOnOrderDecreaseOnCreation();
    }

    /**
     * Load an existing object from the database
     */
    protected function getExistingObject()
    {
        return StockOnOrderDecreaseOnCreationQuery::create()
            ->findPk($this->requestStack->getCurrentRequest()->query->get("stock_on_order_decrease_on_creation_id"))
        ;
    }

    /**
     * Returns the object label form the object event (name, title, etc.)
     *
     * @param mixed $object
     */
    protected function getObjectLabel($object)
    {
        return '';
    }

    /**
     * Returns the object ID from the object
     *
     * @param mixed $object
     */
    protected function getObjectId($object)
    {
        return $object->getId();
    }

    /**
     * Render the main list template
     *
     * @param mixed $currentOrder , if any, null otherwise.
     */
    protected function renderListTemplate($currentOrder)
    {
        $this->getParser()
            ->assign("order", $currentOrder)
        ;

        return $this->render("stock-on-order-decrease-on-creations");
    }

    /**
     * Render the edition template
     */
    protected function renderEditionTemplate()
    {
        $this->parserContext
            ->set(
                "stock_on_order_decrease_on_creation_id",
                $this->requestStack->getCurrentRequest()->query->get("stock_on_order_decrease_on_creation_id")
            )
        ;

        return $this->render("stock-on-order-decrease-on-creation-edit");
    }

    /**
     * Must return a RedirectResponse instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToEditionTemplate()
    {
        $id = $this->requestStack->getCurrentRequest()->query->get("stock_on_order_decrease_on_creation_id");

        return new RedirectResponse(
            URL::getInstance()->absoluteUrl(
                "/admin/module/StockOnOrder/stock_on_order_decrease_on_creation/edit",
                [
                    "stock_on_order_decrease_on_creation_id" => $id,
                ]
            )
        );
    }

    /**
     * Must return a RedirectResponse instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToListTemplate()
    {
        return new RedirectResponse(
            URL::getInstance()->absoluteUrl("/admin/module/StockOnOrder/stock_on_order_decrease_on_creation")
        );
    }
}
