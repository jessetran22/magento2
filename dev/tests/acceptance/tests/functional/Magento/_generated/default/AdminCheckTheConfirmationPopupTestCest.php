<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("[NO TESTCASEID]: Admin confirmation modal should be in Magento style")
 * @Description("Testing the confirmation modal for removing the tracking number<h3>Test files</h3>app/code/Magento/Shipping/Test/Mftf/Test/AdminCheckTheConfirmationPopupTest.xml<br>")
 * @group shipping
 */
class AdminCheckTheConfirmationPopupTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Stories({"Admin confirmation modal should be in Magento style"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Shipping"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckTheConfirmationPopupTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToCreateOrderPage] CreateOrderActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_create/index"); // stepKey: navigateToNewOrderPageGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForNewOrderPageOpenedGoToCreateOrderPage
		$I->click("(//td[contains(text(),'" . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . "')])[1]"); // stepKey: chooseCustomerGoToCreateOrderPage
		$I->waitForPageLoad(60); // stepKey: chooseCustomerGoToCreateOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageOpenedGoToCreateOrderPage
		$I->click("#add_products"); // stepKey: clickOnAddProductsGoToCreateOrderPage
		$I->waitForPageLoad(60); // stepKey: clickOnAddProductsGoToCreateOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductsListForOrderGoToCreateOrderPage
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "')]"); // stepKey: chooseTheProductGoToCreateOrderPage
		$I->waitForPageLoad(60); // stepKey: chooseTheProductGoToCreateOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickProductGoToCreateOrderPage
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: addSelectedProductToOrderGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: addSelectedProductToOrderGoToCreateOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductAddedInOrderGoToCreateOrderPage
		$I->click("//span[text()='Get shipping methods and rates']"); // stepKey: openShippingMethodGoToCreateOrderPage
		$I->waitForPageLoad(60); // stepKey: openShippingMethodGoToCreateOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsGoToCreateOrderPage
		$I->click("//label[contains(text(), 'Fixed')]"); // stepKey: chooseShippingMethodGoToCreateOrderPage
		$I->waitForPageLoad(60); // stepKey: chooseShippingMethodGoToCreateOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsThickenedGoToCreateOrderPage
		$I->click("#submit_order_top_button"); // stepKey: submitOrderGoToCreateOrderPage
		$I->waitForPageLoad(60); // stepKey: submitOrderGoToCreateOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSubmitOrderGoToCreateOrderPage
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderGoToCreateOrderPage
		$I->comment("Exiting Action Group [goToCreateOrderPage] CreateOrderActionGroup");
		$orderId = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: orderId
		$I->comment("Entering Action Group [createShipmentForOrder] AdminShipThePendingOrderActionGroup");
		$I->waitForElementVisible("#order_ship", 30); // stepKey: waitForShipTabCreateShipmentForOrder
		$I->waitForPageLoad(30); // stepKey: waitForShipTabCreateShipmentForOrderWaitForPageLoad
		$I->click("#order_ship"); // stepKey: clickShipButtonCreateShipmentForOrder
		$I->waitForPageLoad(30); // stepKey: clickShipButtonCreateShipmentForOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingPageToLoadCreateShipmentForOrder
		$I->scrollTo("button.action-default.save.submit-button"); // stepKey: scrollToSubmitShipmentButtonCreateShipmentForOrder
		$I->waitForPageLoad(60); // stepKey: scrollToSubmitShipmentButtonCreateShipmentForOrderWaitForPageLoad
		$I->click("button.action-default.save.submit-button"); // stepKey: clickOnSubmitShipmentButtonCreateShipmentForOrder
		$I->waitForPageLoad(60); // stepKey: clickOnSubmitShipmentButtonCreateShipmentForOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitToProcessShippingPageToLoadCreateShipmentForOrder
		$I->see("Processing", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatusCreateShipmentForOrder
		$I->see("The shipment has been created.", "div.message-success"); // stepKey: seeShipmentCreateSuccessCreateShipmentForOrder
		$I->comment("Exiting Action Group [createShipmentForOrder] AdminShipThePendingOrderActionGroup");
		$I->comment("Entering Action Group [filterForNewlyCreatedShipment] FilterShipmentGridByOrderIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/shipment/"); // stepKey: goToShipmentsFilterForNewlyCreatedShipment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFilterForNewlyCreatedShipment
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearOrderFiltersFilterForNewlyCreatedShipment
		$I->waitForPageLoad(30); // stepKey: clearOrderFiltersFilterForNewlyCreatedShipmentWaitForPageLoad
		$I->click("[data-action='grid-filter-expand']"); // stepKey: clickFilterFilterForNewlyCreatedShipment
		$I->fillField("input[name='order_increment_id']", "$orderId"); // stepKey: fillOrderIdForFilterFilterForNewlyCreatedShipment
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterForNewlyCreatedShipment
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterForNewlyCreatedShipmentWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersApplyFilterForNewlyCreatedShipment
		$I->comment("Exiting Action Group [filterForNewlyCreatedShipment] FilterShipmentGridByOrderIdActionGroup");
		$I->comment("Entering Action Group [selectShipmentFromGrid] AdminSelectFirstGridRowActionGroup");
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: clickFirstRowInGridSelectShipmentFromGrid
		$I->waitForPageLoad(60); // stepKey: clickFirstRowInGridSelectShipmentFromGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitToProcessPageToLoadSelectShipmentFromGrid
		$I->comment("Exiting Action Group [selectShipmentFromGrid] AdminSelectFirstGridRowActionGroup");
		$I->comment("Entering Action Group [addTrackingNumber] AdminAddTrackingNumberToShipmentActionGroup");
		$I->fillField("#tracking-shipping-form #tracking_title", ""); // stepKey: fillTrackingTitleAddTrackingNumber
		$I->fillField("#tracking-shipping-form #tracking_number", "123123"); // stepKey: fillTrackingNumberAddTrackingNumber
		$I->click("#tracking-shipping-form button.save"); // stepKey: clickAddTrackingNumberAddTrackingNumber
		$I->waitForPageLoad(30); // stepKey: waitForTrackingInformationAddTrackingNumber
		$I->comment("Exiting Action Group [addTrackingNumber] AdminAddTrackingNumberToShipmentActionGroup");
		$I->comment("Entering Action Group [deleteTrackingNumber] AdminDeleteTrackingNumberActionGroup");
		$I->click("#tracking-shipping-form button.action-delete"); // stepKey: clickDeleteButtonDeleteTrackingNumber
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteTrackingNumber
		$I->waitForElementVisible(".modal-popup.confirm div.modal-content", 30); // stepKey: waitForConfirmModalDeleteTrackingNumber
		$I->see("Are you sure?", ".modal-popup.confirm div.modal-content"); // stepKey: seeRemoveMessageDeleteTrackingNumber
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: clickOkButtonDeleteTrackingNumber
		$I->waitForPageLoad(60); // stepKey: clickOkButtonDeleteTrackingNumberWaitForPageLoad
		$I->comment("Exiting Action Group [deleteTrackingNumber] AdminDeleteTrackingNumberActionGroup");
	}
}
