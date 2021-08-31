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
 * @group reports
 * @Title("MAGETWO-95960: Canceled orders in order sales report")
 * @Description("Verify canceling of orders in order sales report<h3>Test files</h3>app/code/Magento/Reports/Test/Mftf/Test/AdminCanceledOrdersInOrderSalesReportTest.xml<br>")
 * @TestCaseId("MAGETWO-95960")
 */
class AdminCanceledOrdersInOrderSalesReportTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->createEntity("createCustomerCartOne", "hook", "CustomerCart", ["createCustomer"], []); // stepKey: createCustomerCartOne
		$I->createEntity("addCartItemOne", "hook", "CustomerCartItem", ["createCustomerCartOne", "createSimpleProduct"], []); // stepKey: addCartItemOne
		$I->createEntity("addCustomerOrderAddress", "hook", "CustomerAddressInformation", ["createCustomerCartOne"], []); // stepKey: addCustomerOrderAddress
		$I->updateEntity("createCustomerCartOne", "hook", "CustomerOrderPaymentMethod",["createCustomerCartOne"]); // stepKey: sendCustomerPaymentInformationOne
		$I->createEntity("invoiceOrderOne", "hook", "Invoice", ["createCustomerCartOne"], []); // stepKey: invoiceOrderOne
		$I->createEntity("shipOrderOne", "hook", "Shipment", ["createCustomerCartOne"], []); // stepKey: shipOrderOne
		$I->createEntity("createCustomerCartTwo", "hook", "CustomerCart", ["createCustomer"], []); // stepKey: createCustomerCartTwo
		$I->createEntity("addCartItemTwo", "hook", "CustomerCartItem", ["createCustomerCartTwo", "createSimpleProduct"], []); // stepKey: addCartItemTwo
		$I->createEntity("addCustomerOrderAddressTwo", "hook", "CustomerAddressInformation", ["createCustomerCartTwo"], []); // stepKey: addCustomerOrderAddressTwo
		$I->updateEntity("createCustomerCartTwo", "hook", "CustomerOrderPaymentMethod",["createCustomerCartTwo"]); // stepKey: sendCustomerPaymentInformationTwo
		$I->createEntity("cancelOrderTwo", "hook", "CancelOrder", ["createCustomerCartTwo"], []); // stepKey: cancelOrderTwo
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
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
	 * @Features({"Reports"})
	 * @Stories({"Order Sales Report includes canceled orders"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCanceledOrdersInOrderSalesReportTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToOrdersReportPage1] AdminGoToOrdersReportPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/reports/report_sales/sales/"); // stepKey: goToOrdersReportPageGoToOrdersReportPage1
		$I->waitForPageLoad(30); // stepKey: waitForOrdersReportPageLoadGoToOrdersReportPage1
		$I->comment("Exiting Action Group [goToOrdersReportPage1] AdminGoToOrdersReportPageActionGroup");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("+0 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$generateEndDate = $date->format("m/d/Y");

		$date = new \DateTime();
		$date->setTimestamp(strtotime("-1 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$generateStartDate = $date->format("m/d/Y");

		$I->comment("Entering Action Group [generateReportAfterCancelOrderBefore] GenerateOrderReportForNotCancelActionGroup");
		$I->click("//a[contains(text(), 'here')]"); // stepKey: clickOnHereGenerateReportAfterCancelOrderBefore
		$I->waitForPageLoad(60); // stepKey: clickOnHereGenerateReportAfterCancelOrderBeforeWaitForPageLoad
		$I->fillField("#sales_report_from", "$generateStartDate"); // stepKey: fillFromDateGenerateReportAfterCancelOrderBefore
		$I->fillField("#sales_report_to", "$generateEndDate"); // stepKey: fillToDateGenerateReportAfterCancelOrderBefore
		$I->selectOption("#sales_report_show_order_statuses", "Specified"); // stepKey: selectSpecifiedOptionGenerateReportAfterCancelOrderBefore
		$I->selectOption("#sales_report_order_statuses", ['closed',  'complete',  'fraud',  'holded',  'payment_review',  'paypal_canceled_reversal',  'paypal_reversed',  'processing']); // stepKey: selectSpecifiedOptionStatusGenerateReportAfterCancelOrderBefore
		$I->click("#filter_form_submit"); // stepKey: showReportGenerateReportAfterCancelOrderBefore
		$I->waitForPageLoad(60); // stepKey: showReportGenerateReportAfterCancelOrderBeforeWaitForPageLoad
		$I->comment("Exiting Action Group [generateReportAfterCancelOrderBefore] GenerateOrderReportForNotCancelActionGroup");
		$I->waitForElement("//tr[@class='totals']/th[@class=' col-orders col-orders_count col-number']", 30); // stepKey: waitForOrdersCountBefore
		$grabCanceledOrdersSpecified = $I->grabTextFrom("//tr[@class='totals']/th[@class=' col-orders col-orders_count col-number']"); // stepKey: grabCanceledOrdersSpecified
		$I->comment("Entering Action Group [goToOrdersReportPage2] AdminGoToOrdersReportPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/reports/report_sales/sales/"); // stepKey: goToOrdersReportPageGoToOrdersReportPage2
		$I->waitForPageLoad(30); // stepKey: waitForOrdersReportPageLoadGoToOrdersReportPage2
		$I->comment("Exiting Action Group [goToOrdersReportPage2] AdminGoToOrdersReportPageActionGroup");
		$I->comment("Entering Action Group [generateReportAfterCancelOrder] GenerateOrderReportActionGroup");
		$I->click("//a[contains(text(), 'here')]"); // stepKey: clickOnHereGenerateReportAfterCancelOrder
		$I->waitForPageLoad(60); // stepKey: clickOnHereGenerateReportAfterCancelOrderWaitForPageLoad
		$I->fillField("#sales_report_from", "$generateStartDate"); // stepKey: fillFromDateGenerateReportAfterCancelOrder
		$I->fillField("#sales_report_to", "$generateEndDate"); // stepKey: fillToDateGenerateReportAfterCancelOrder
		$I->selectOption("#sales_report_show_order_statuses", "Any"); // stepKey: selectAnyOptionGenerateReportAfterCancelOrder
		$I->click("#filter_form_submit"); // stepKey: showReportGenerateReportAfterCancelOrder
		$I->waitForPageLoad(60); // stepKey: showReportGenerateReportAfterCancelOrderWaitForPageLoad
		$I->comment("Exiting Action Group [generateReportAfterCancelOrder] GenerateOrderReportActionGroup");
		$I->waitForElement("//tr[@class='totals']/th[@class=' col-orders col-orders_count col-number']", 30); // stepKey: waitForOrdersCount
		$grabCanceledOrdersAny = $I->grabTextFrom("//tr[@class='totals']/th[@class=' col-orders col-orders_count col-number']"); // stepKey: grabCanceledOrdersAny
		$I->assertEquals($grabCanceledOrdersSpecified, $grabCanceledOrdersAny); // stepKey: assertEquals
	}
}
