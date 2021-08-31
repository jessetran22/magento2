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
 * @Title("MC-16182: Mass cancel orders in status Pending")
 * @Description("Mass cancel orders in status Pending<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminMassOrdersUpdateCancelPendingOrderTest.xml<br>")
 * @TestCaseId("MC-16182")
 * @group sales
 * @group mtf_migrated
 */
class AdminMassOrdersUpdateCancelPendingOrderTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "defaultSimpleProduct", ["createCategory"], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Mass Update Orders"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMassOrdersUpdateCancelPendingOrderTest(AcceptanceTester $I)
	{
		$I->createEntity("createCustomerCart", "test", "CustomerCart", ["createCustomer"], []); // stepKey: createCustomerCart
		$I->createEntity("addCartItem", "test", "CustomerCartItem", ["createCustomerCart", "createProduct"], []); // stepKey: addCartItem
		$I->createEntity("addCustomerOrderAddress", "test", "CustomerAddressInformation", ["createCustomerCart"], []); // stepKey: addCustomerOrderAddress
		$I->updateEntity("createCustomerCart", "test", "CustomerOrderPaymentMethod",["createCustomerCart"]); // stepKey: createOrder
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [onOrderPage] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageOnOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageOnOrderPage
		$I->comment("Exiting Action Group [onOrderPage] AdminOrdersPageOpenActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearFilters
		$I->comment("Exiting Action Group [clearFilters] AdminOrdersGridClearFiltersActionGroup");
		$grabOrderId = $I->grabTextFrom("//input[@class='admin__control-checkbox' and @value=" . $I->retrieveEntityField('createCustomerCart', 'return', 'test') . "]/parent::label/parent::td/following-sibling::td"); // stepKey: grabOrderId
		$I->comment("Entering Action Group [ActionCancel] AdminOrderActionOnGridActionGroup");
		$I->checkOption("//td/div[text()='$grabOrderId']/../preceding-sibling::td//input"); // stepKey: selectOrderActionCancel
		$I->waitForPageLoad(60); // stepKey: selectOrderActionCancelWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCheckActionCancel
		$I->click(".action-select-wrap > .action-select"); // stepKey: openActionsActionCancel
		$I->waitForPageLoad(30); // stepKey: openActionsActionCancelWaitForPageLoad
		$I->click("(//div[contains(@class, 'action-menu-items')]//span[text()='Cancel'])[1]"); // stepKey: selectActionActionCancel
		$I->waitForPageLoad(30); // stepKey: selectActionActionCancelWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResultsActionCancel
		$I->comment("Exiting Action Group [ActionCancel] AdminOrderActionOnGridActionGroup");
		$I->see("We canceled 1 order(s)."); // stepKey: assertOrderCancelMassActionSuccessMessage
		$I->comment("Entering Action Group [filterOrder] AdminOrderFilterByOrderIdAndStatusActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrder
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageFilterOrder
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrder
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderId); // stepKey: fillOrderIdFilterFilterOrder
		$I->selectOption("select[name='status']", "Canceled"); // stepKey: selectOrderStatusFilterOrder
		$I->waitForPageLoad(60); // stepKey: selectOrderStatusFilterOrderWaitForPageLoad
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrder
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskFilterOrder
		$I->comment("Exiting Action Group [filterOrder] AdminOrderFilterByOrderIdAndStatusActionGroup");
		$I->see($grabOrderId, "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'ID')]/preceding-sibling::th) +1 ]"); // stepKey: assertOrderID
		$I->see("Canceled", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Status')]/preceding-sibling::th) +1 ]"); // stepKey: assertOrderStatus
	}
}
