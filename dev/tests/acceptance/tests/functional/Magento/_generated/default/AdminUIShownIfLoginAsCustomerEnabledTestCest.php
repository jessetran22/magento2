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
 * @Title("[NO TESTCASEID]: UI elements are shown if 'Login as customer' functionality is enabled")
 * @Description("Verify that UI elements are present and links are working if 'Login as customer' functionality enabled<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/AdminUIShownIfLoginAsCustomerEnabledTest.xml<br>")
 * @group login_as_customer
 */
class AdminUIShownIfLoginAsCustomerEnabledTestCest
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
		$enableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 1", 60); // stepKey: enableLoginAsCustomer
		$I->comment($enableLoginAsCustomer);
		$enableLoginAsCustomerAutoDetection = $I->magentoCLI("config:set login_as_customer/general/store_view_manual_choice_enabled 0", 60); // stepKey: enableLoginAsCustomerAutoDetection
		$I->comment($enableLoginAsCustomerAutoDetection);
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
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [cleanInvalidatedCachesAfterSet] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCachesAfterSet = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCachesAfterSet
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCachesAfterSet);
		$I->comment("Exiting Action Group [cleanInvalidatedCachesAfterSet] CliCacheCleanActionGroup");
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
		$I->comment("Entering Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearOrderFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearOrderFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearOrderFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearOrderFilters
		$I->comment("Exiting Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$disableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 0", 60); // stepKey: disableLoginAsCustomer
		$I->comment($disableLoginAsCustomer);
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [cleanInvalidatedCachesDefault] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCachesDefault = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCachesDefault
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCachesDefault);
		$I->comment("Exiting Action Group [cleanInvalidatedCachesDefault] CliCacheCleanActionGroup");
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
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUIShownIfLoginAsCustomerEnabledTest(AcceptanceTester $I)
	{
		$I->comment("Verify Login as Customer Login action works correctly from Customer page");
		$I->comment("Entering Action Group [verifyLoginAsCustomerWorksOnCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: gotoCustomerPageVerifyLoginAsCustomerWorksOnCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadVerifyLoginAsCustomerWorksOnCustomerPage
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkVerifyLoginAsCustomerWorksOnCustomerPage
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkVerifyLoginAsCustomerWorksOnCustomerPageWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalVerifyLoginAsCustomerWorksOnCustomerPage
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageVerifyLoginAsCustomerWorksOnCustomerPage
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginVerifyLoginAsCustomerWorksOnCustomerPage
		$I->waitForPageLoad(60); // stepKey: clickLoginVerifyLoginAsCustomerWorksOnCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearVerifyLoginAsCustomerWorksOnCustomerPage
		$I->switchToNextTab(); // stepKey: switchToNewTabVerifyLoginAsCustomerWorksOnCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadVerifyLoginAsCustomerWorksOnCustomerPage
		$I->comment("Exiting Action Group [verifyLoginAsCustomerWorksOnCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Entering Action Group [assertLoggedInFromCustomerPage] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->seeInCurrentUrl("/customer/account/"); // stepKey: assertOnCustomerAccountPageAssertLoggedInFromCustomerPage
		$I->see("Welcome, " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . "!", "header>.panel .greet.welcome"); // stepKey: assertCorrectWelcomeMessageAssertLoggedInFromCustomerPage
		$I->see($I->retrieveEntityField('createCustomer', 'email', 'test'), ".box.box-information .box-content"); // stepKey: assertCustomerEmailInContactInformationAssertLoggedInFromCustomerPage
		$I->comment("Exiting Action Group [assertLoggedInFromCustomerPage] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->comment("Entering Action Group [signOutAfterLoggedInFromCustomerPage] StorefrontSignOutAndCloseTabActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonSignOutAfterLoggedInFromCustomerPage
		$I->waitForElementVisible("div.customer-menu  li.authorization-link", 30); // stepKey: waitForSignOutSignOutAfterLoggedInFromCustomerPage
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutSignOutAfterLoggedInFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSignOutAfterLoggedInFromCustomerPage
		$I->see("You are signed out"); // stepKey: signOutSignOutAfterLoggedInFromCustomerPage
		$I->closeTab(); // stepKey: closeTabSignOutAfterLoggedInFromCustomerPage
		$I->comment("Exiting Action Group [signOutAfterLoggedInFromCustomerPage] StorefrontSignOutAndCloseTabActionGroup");
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
		$grabOrderId = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderId
		$I->comment("Verify Login as Customer Login action works correctly from Order page");
		$I->comment("Entering Action Group [verifyLoginAsCustomerWorksOnOrderPage] AdminLoginAsCustomerLoginFromOrderPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/$grabOrderId"); // stepKey: gotoOrderPageVerifyLoginAsCustomerWorksOnOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoadVerifyLoginAsCustomerWorksOnOrderPage
		$I->click("#guest_to_customer"); // stepKey: clickLoginAsCustomerLinkVerifyLoginAsCustomerWorksOnOrderPage
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkVerifyLoginAsCustomerWorksOnOrderPageWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalVerifyLoginAsCustomerWorksOnOrderPage
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageVerifyLoginAsCustomerWorksOnOrderPage
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginVerifyLoginAsCustomerWorksOnOrderPage
		$I->waitForPageLoad(60); // stepKey: clickLoginVerifyLoginAsCustomerWorksOnOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearVerifyLoginAsCustomerWorksOnOrderPage
		$I->switchToNextTab(); // stepKey: switchToNewTabVerifyLoginAsCustomerWorksOnOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadVerifyLoginAsCustomerWorksOnOrderPage
		$I->comment("Exiting Action Group [verifyLoginAsCustomerWorksOnOrderPage] AdminLoginAsCustomerLoginFromOrderPageActionGroup");
		$I->comment("Entering Action Group [assertLoggedInFromOrderPage] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->seeInCurrentUrl("/customer/account/"); // stepKey: assertOnCustomerAccountPageAssertLoggedInFromOrderPage
		$I->see("Welcome, " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . "!", "header>.panel .greet.welcome"); // stepKey: assertCorrectWelcomeMessageAssertLoggedInFromOrderPage
		$I->see($I->retrieveEntityField('createCustomer', 'email', 'test'), ".box.box-information .box-content"); // stepKey: assertCustomerEmailInContactInformationAssertLoggedInFromOrderPage
		$I->comment("Exiting Action Group [assertLoggedInFromOrderPage] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->comment("Entering Action Group [signOutAfterLoggedInFromOrderPage] StorefrontSignOutAndCloseTabActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonSignOutAfterLoggedInFromOrderPage
		$I->waitForElementVisible("div.customer-menu  li.authorization-link", 30); // stepKey: waitForSignOutSignOutAfterLoggedInFromOrderPage
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutSignOutAfterLoggedInFromOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSignOutAfterLoggedInFromOrderPage
		$I->see("You are signed out"); // stepKey: signOutSignOutAfterLoggedInFromOrderPage
		$I->closeTab(); // stepKey: closeTabSignOutAfterLoggedInFromOrderPage
		$I->comment("Exiting Action Group [signOutAfterLoggedInFromOrderPage] StorefrontSignOutAndCloseTabActionGroup");
	}
}
