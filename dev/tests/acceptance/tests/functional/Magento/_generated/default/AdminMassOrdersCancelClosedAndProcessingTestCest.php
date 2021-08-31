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
 * @Title("MC-16184: Mass cancel orders in status  Processing, Closed")
 * @Description("Try to cancel orders in status Processing, Closed<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminMassOrdersCancelClosedAndProcessingTest.xml<br>")
 * @TestCaseId("MC-16184")
 * @group sales
 * @group mtf_migrated
 */
class AdminMassOrdersCancelClosedAndProcessingTestCest
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
		$I->createEntity("createCustomerCartOne", "hook", "CustomerCart", ["createCustomer"], []); // stepKey: createCustomerCartOne
		$I->createEntity("addCartItemOne", "hook", "CustomerCartItem", ["createCustomerCartOne", "createProduct"], []); // stepKey: addCartItemOne
		$I->createEntity("addCustomerOrderAddress", "hook", "CustomerAddressInformation", ["createCustomerCartOne"], []); // stepKey: addCustomerOrderAddress
		$I->updateEntity("createCustomerCartOne", "hook", "CustomerOrderPaymentMethod",["createCustomerCartOne"]); // stepKey: sendCustomerPaymentInformationOne
		$I->createEntity("invoiceOrderOne", "hook", "Invoice", ["createCustomerCartOne"], []); // stepKey: invoiceOrderOne
		$I->createEntity("createCustomerCartTwo", "hook", "CustomerCart", ["createCustomer"], []); // stepKey: createCustomerCartTwo
		$I->createEntity("addCartItemTwo", "hook", "CustomerCartItem", ["createCustomerCartTwo", "createProduct"], []); // stepKey: addCartItemTwo
		$I->createEntity("addCustomerOrderAddressTwo", "hook", "CustomerAddressInformation", ["createCustomerCartTwo"], []); // stepKey: addCustomerOrderAddressTwo
		$I->updateEntity("createCustomerCartTwo", "hook", "CustomerOrderPaymentMethod",["createCustomerCartTwo"]); // stepKey: sendCustomerPaymentInformationTwo
		$I->createEntity("invoiceOrderTwo", "hook", "Invoice", ["createCustomerCartTwo"], []); // stepKey: invoiceOrderTwo
		$I->createEntity("refundOrderTwo", "hook", "CreditMemo", ["createCustomerCartTwo"], []); // stepKey: refundOrderTwo
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
	public function AdminMassOrdersCancelClosedAndProcessingTest(AcceptanceTester $I)
	{
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
		$getFirstOrderId = $I->grabTextFrom("//input[@class='admin__control-checkbox' and @value=" . $I->retrieveEntityField('createCustomerCartOne', 'return', 'test') . "]/parent::label/parent::td/following-sibling::td"); // stepKey: getFirstOrderId
		$getSecondOrderId = $I->grabTextFrom("//input[@class='admin__control-checkbox' and @value=" . $I->retrieveEntityField('createCustomerCartTwo', 'return', 'test') . "]/parent::label/parent::td/following-sibling::td"); // stepKey: getSecondOrderId
		$I->comment("Entering Action Group [massActionCancel] AdminTwoOrderActionOnGridActionGroup");
		$I->checkOption("//td/div[text()='{$getFirstOrderId}']/../preceding-sibling::td//input"); // stepKey: selectOrderMassActionCancel
		$I->waitForPageLoad(60); // stepKey: selectOrderMassActionCancelWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCheckMassActionCancel
		$I->checkOption("//td/div[text()='{$getSecondOrderId}']/../preceding-sibling::td//input"); // stepKey: selectSecondOrderMassActionCancel
		$I->waitForPageLoad(60); // stepKey: selectSecondOrderMassActionCancelWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondCheckMassActionCancel
		$I->click(".action-select-wrap > .action-select"); // stepKey: openActionsMassActionCancel
		$I->waitForPageLoad(30); // stepKey: openActionsMassActionCancelWaitForPageLoad
		$I->click("(//div[contains(@class, 'action-menu-items')]//span[text()='Cancel'])[1]"); // stepKey: selectActionMassActionCancel
		$I->waitForPageLoad(30); // stepKey: selectActionMassActionCancelWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResultsMassActionCancel
		$I->comment("Exiting Action Group [massActionCancel] AdminTwoOrderActionOnGridActionGroup");
		$I->see("You cannot cancel the order(s)."); // stepKey: assertOrderCancelMassActionFailMessage
		$I->comment("Entering Action Group [seeFirstOrder] AdminOrderFilterByOrderIdAndStatusActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageSeeFirstOrder
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageSeeFirstOrder
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersSeeFirstOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersSeeFirstOrderWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersSeeFirstOrder
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersSeeFirstOrderWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $getFirstOrderId); // stepKey: fillOrderIdFilterSeeFirstOrder
		$I->selectOption("select[name='status']", "Processing"); // stepKey: selectOrderStatusSeeFirstOrder
		$I->waitForPageLoad(60); // stepKey: selectOrderStatusSeeFirstOrderWaitForPageLoad
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSeeFirstOrder
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSeeFirstOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSeeFirstOrder
		$I->comment("Exiting Action Group [seeFirstOrder] AdminOrderFilterByOrderIdAndStatusActionGroup");
		$I->see($getFirstOrderId, "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'ID')]/preceding-sibling::th) +1 ]"); // stepKey: assertFirstOrderID
		$I->see("Processing", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Status')]/preceding-sibling::th) +1 ]"); // stepKey: assertFirstOrderStatus
		$I->comment("Entering Action Group [seeSecondOrder] AdminOrderFilterByOrderIdAndStatusActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageSeeSecondOrder
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageSeeSecondOrder
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersSeeSecondOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersSeeSecondOrderWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersSeeSecondOrder
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersSeeSecondOrderWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $getSecondOrderId); // stepKey: fillOrderIdFilterSeeSecondOrder
		$I->selectOption("select[name='status']", "Closed"); // stepKey: selectOrderStatusSeeSecondOrder
		$I->waitForPageLoad(60); // stepKey: selectOrderStatusSeeSecondOrderWaitForPageLoad
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSeeSecondOrder
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSeeSecondOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSeeSecondOrder
		$I->comment("Exiting Action Group [seeSecondOrder] AdminOrderFilterByOrderIdAndStatusActionGroup");
		$I->see($getSecondOrderId, "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'ID')]/preceding-sibling::th) +1 ]"); // stepKey: assertSecondOrderID
		$I->see("Closed", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Status')]/preceding-sibling::th) +1 ]"); // stepKey: assertSecondStatus
	}
}
