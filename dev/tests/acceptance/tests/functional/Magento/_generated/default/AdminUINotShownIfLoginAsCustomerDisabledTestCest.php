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
 * @Title("[NO TESTCASEID]: UI elements are not shown if 'Login as customer' functionality is disabled")
 * @Description("Verify that UI elements are not shown if 'Login as customer' functionality is disabled<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/AdminUINotShownIfLoginAsCustomerDisabledTest.xml<br>")
 * @group login_as_customer
 */
class AdminUINotShownIfLoginAsCustomerDisabledTestCest
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
		$disableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 0", 60); // stepKey: disableLoginAsCustomer
		$I->comment($disableLoginAsCustomer);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Assistance_Allowed", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
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
	 * @Features({"LoginAsCustomer"})
	 * @Stories({"Availability of UI elements if module enable/disable"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUINotShownIfLoginAsCustomerDisabledTest(AcceptanceTester $I)
	{
		$I->comment("Verify Login as Customer Login action is absent on Customer page");
		$I->comment("Entering Action Group [verifyLoginAsCustomerAbsentOnCustomerPage] AdminLoginAsCustomerAbsentOnCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: gotoCustomerPageVerifyLoginAsCustomerAbsentOnCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadVerifyLoginAsCustomerAbsentOnCustomerPage
		$I->dontSee("Login as Customer"); // stepKey: dontSeeLoginAsCustomerVerifyLoginAsCustomerAbsentOnCustomerPage
		$I->comment("Exiting Action Group [verifyLoginAsCustomerAbsentOnCustomerPage] AdminLoginAsCustomerAbsentOnCustomerPageActionGroup");
		$I->comment("Create order");
		$I->comment("Entering Action Group [createOrder] CreateOrderActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_create/index"); // stepKey: navigateToNewOrderPageCreateOrder
		$I->waitForPageLoad(30); // stepKey: waitForNewOrderPageOpenedCreateOrder
		$I->click("(//td[contains(text(),'" . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . "')])[1]"); // stepKey: chooseCustomerCreateOrder
		$I->waitForPageLoad(60); // stepKey: chooseCustomerCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageOpenedCreateOrder
		$I->click("#add_products"); // stepKey: clickOnAddProductsCreateOrder
		$I->waitForPageLoad(60); // stepKey: clickOnAddProductsCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductsListForOrderCreateOrder
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "')]"); // stepKey: chooseTheProductCreateOrder
		$I->waitForPageLoad(60); // stepKey: chooseTheProductCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickProductCreateOrder
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: addSelectedProductToOrderCreateOrder
		$I->waitForPageLoad(30); // stepKey: addSelectedProductToOrderCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductAddedInOrderCreateOrder
		$I->click("//span[text()='Get shipping methods and rates']"); // stepKey: openShippingMethodCreateOrder
		$I->waitForPageLoad(60); // stepKey: openShippingMethodCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsCreateOrder
		$I->click("//label[contains(text(), 'Fixed')]"); // stepKey: chooseShippingMethodCreateOrder
		$I->waitForPageLoad(60); // stepKey: chooseShippingMethodCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsThickenedCreateOrder
		$I->click("#submit_order_top_button"); // stepKey: submitOrderCreateOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSubmitOrderCreateOrder
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderCreateOrder
		$I->comment("Exiting Action Group [createOrder] CreateOrderActionGroup");
		$grabOrderId = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: grabOrderId
		$I->comment("Verify Login as Customer Login action is absent on Order page");
		$I->comment("Entering Action Group [verifyLoginAsCustomerAbsentOnOrderPage] AdminLoginAsCustomerAbsentOnOrderPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/{$grabOrderId}"); // stepKey: gotoOrderPageVerifyLoginAsCustomerAbsentOnOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoadVerifyLoginAsCustomerAbsentOnOrderPage
		$I->dontSee("Login as Customer"); // stepKey: dontSeeLoginAsCustomerVerifyLoginAsCustomerAbsentOnOrderPage
		$I->comment("Exiting Action Group [verifyLoginAsCustomerAbsentOnOrderPage] AdminLoginAsCustomerAbsentOnOrderPageActionGroup");
	}
}
