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
 * @Title("[NO TESTCASEID]: Admin user can disable shipment comments")
 * @Description("Disabling Shipment comments<h3>Test files</h3>app/code/Magento/Shipping/Test/Mftf/Test/AdminDisableShipmentCommentsTest.xml<br>")
 * @group shipping
 */
class AdminDisableShipmentCommentsTestCest
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
		$I->createEntity("createCustomerCart", "hook", "CustomerCart", ["createCustomer"], []); // stepKey: createCustomerCart
		$I->createEntity("addCartItem", "hook", "CustomerCartItem", ["createCustomerCart", "createSimpleProduct"], []); // stepKey: addCartItem
		$I->createEntity("addCustomerOrderAddress", "hook", "CustomerAddressInformation", ["createCustomerCart"], []); // stepKey: addCustomerOrderAddress
		$I->updateEntity("createCustomerCart", "hook", "CustomerOrderPaymentMethod",["createCustomerCart"]); // stepKey: sendCustomerPaymentInformation
		$I->createEntity("shipOrder", "hook", "Shipment", ["createCustomerCart"], []); // stepKey: shipOrder
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$disableShipmentComments = $I->magentoCLI("config:set sales_email/shipment_comment/enabled 0", 60); // stepKey: disableShipmentComments
		$I->comment($disableShipmentComments);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$disableShipmentComments = $I->magentoCLI("config:set sales_email/shipment_comment/enabled 1", 60); // stepKey: disableShipmentComments
		$I->comment($disableShipmentComments);
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
	 * @Stories({"There is no Notify Customer by Email checkbox when shipment comments are disabled"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Shipping"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDisableShipmentCommentsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openOrdersGrid] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageOpenOrdersGrid
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageOpenOrdersGrid
		$I->comment("Exiting Action Group [openOrdersGrid] AdminOrdersPageOpenActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearFilters
		$I->comment("Exiting Action Group [clearFilters] AdminOrdersGridClearFiltersActionGroup");
		$orderId = $I->grabTextFrom("//input[@class='admin__control-checkbox' and @value=" . $I->retrieveEntityField('createCustomerCart', 'return', 'test') . "]/parent::label/parent::td/following-sibling::td"); // stepKey: orderId
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
		$I->comment("Entering Action Group [doNotSeeNotifyCustomerCheckbox] AssertAdminThereIsNoNotifyCustomerByEmailCheckboxActionGroup");
		$I->dontSeeElement("input#history_notify"); // stepKey: doNotSeeCheckboxDoNotSeeNotifyCustomerCheckbox
		$I->comment("Exiting Action Group [doNotSeeNotifyCustomerCheckbox] AssertAdminThereIsNoNotifyCustomerByEmailCheckboxActionGroup");
	}
}
