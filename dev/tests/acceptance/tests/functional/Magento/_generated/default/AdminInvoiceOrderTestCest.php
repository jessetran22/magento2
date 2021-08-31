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
 * @Title("MAGETWO-72096: Admin should be able to create an invoice")
 * @Description("Admin should be able to create an invoice<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminInvoiceOrderTest.xml<br>")
 * @TestCaseId("MAGETWO-72096")
 * @group sales
 */
class AdminInvoiceOrderTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProductApi", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProductApi
		$I->createEntity("createGuestCart", "hook", "GuestCart", [], []); // stepKey: createGuestCart
		$I->createEntity("addCartItem", "hook", "SimpleCartItem", ["createGuestCart", "createSimpleProductApi"], []); // stepKey: addCartItem
		$I->createEntity("addGuestOrderAddress", "hook", "GuestAddressInformation", ["createGuestCart"], []); // stepKey: addGuestOrderAddress
		$I->updateEntity("createGuestCart", "hook", "GuestOrderPaymentMethod",["createGuestCart"]); // stepKey: sendGuestPaymentInformation
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProductApi", "hook"); // stepKey: deleteSimpleProductApi
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"Sales"})
	 * @Stories({"Create an Invoice via the Admin"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminInvoiceOrderTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openOrder] AdminOpenOrderByEntityIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/" . $I->retrieveEntityField('createGuestCart', 'return', 'test')); // stepKey: openOrderOpenOrder
		$I->comment("Exiting Action Group [openOrder] AdminOpenOrderByEntityIdActionGroup");
		$grabOrderId = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: grabOrderId
		$I->comment("Entering Action Group [createInvoice] AdminCreateInvoiceActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceCreateInvoice
		$I->waitForPageLoad(30); // stepKey: clickInvoiceCreateInvoiceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForInvoicePageCreateInvoice
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: submitInvoiceCreateInvoice
		$I->waitForPageLoad(60); // stepKey: submitInvoiceCreateInvoiceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadPageCreateInvoice
		$I->see("The invoice has been created."); // stepKey: seeMessageCreateInvoice
		$I->comment("Exiting Action Group [createInvoice] AdminCreateInvoiceActionGroup");
		$I->comment("Entering Action Group [filterInvoiceGridByOrderId] FilterInvoiceGridByOrderIdWithCleanFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/invoice/"); // stepKey: goToInvoicesFilterInvoiceGridByOrderId
		$I->conditionalClick("button.action-clear", "button.action-clear", true); // stepKey: clearFiltersFilterInvoiceGridByOrderId
		$I->waitForPageLoad(30); // stepKey: clearFiltersFilterInvoiceGridByOrderIdWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: clickFilterFilterInvoiceGridByOrderId
		$I->fillField("input[name='order_increment_id']", "$grabOrderId"); // stepKey: fillOrderIdForFilterFilterInvoiceGridByOrderId
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterInvoiceGridByOrderId
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterInvoiceGridByOrderIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersApplyFilterInvoiceGridByOrderId
		$I->comment("Exiting Action Group [filterInvoiceGridByOrderId] FilterInvoiceGridByOrderIdWithCleanFiltersActionGroup");
		$I->comment("Entering Action Group [openInvoiceFromGrid] AdminSelectFirstGridRowActionGroup");
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: clickFirstRowInGridOpenInvoiceFromGrid
		$I->waitForPageLoad(60); // stepKey: clickFirstRowInGridOpenInvoiceFromGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitToProcessPageToLoadOpenInvoiceFromGrid
		$I->comment("Exiting Action Group [openInvoiceFromGrid] AdminSelectFirstGridRowActionGroup");
		$I->comment("Entering Action Group [checkIfOrderStatusIsProcessing] AdminOrderViewCheckStatusActionGroup");
		$I->see("Processing", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatusCheckIfOrderStatusIsProcessing
		$I->comment("Exiting Action Group [checkIfOrderStatusIsProcessing] AdminOrderViewCheckStatusActionGroup");
	}
}
