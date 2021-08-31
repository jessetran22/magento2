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
 * @Title("[NO TESTCASEID]: Admin user directly login into customer account with store View To Login In = Auto detection")
 * @Description("Verify admin user can directly login into customer account to Default store view when Store View To Login In = Auto detection<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/AdminLoginAsCustomerAutoDetectionTest.xml<br>")
 * @group login_as_customer
 */
class AdminLoginAsCustomerAutoDetectionTestCest
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
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Assistance_Allowed", [], []); // stepKey: createCustomer
		$enableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 1", 60); // stepKey: enableLoginAsCustomer
		$I->comment($enableLoginAsCustomer);
		$enableLoginAsCustomerAutoDetection = $I->magentoCLI("config:set login_as_customer/general/store_view_manual_choice_enabled 0", 60); // stepKey: enableLoginAsCustomerAutoDetection
		$I->comment($enableLoginAsCustomerAutoDetection);
		$enableAddStoreCodeToUrls = $I->magentoCLI("config:set web/url/use_store 1", 60); // stepKey: enableAddStoreCodeToUrls
		$I->comment($enableAddStoreCodeToUrls);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
		$I->comment("Entering Action Group [adminLogin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameAdminLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordAdminLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginAdminLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginAdminLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleAdminLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationAdminLogin
		$I->comment("Exiting Action Group [adminLogin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateCustomStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateCustomStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateCustomStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateCustomStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateCustomStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateCustomStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateCustomStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateCustomStoreView
		$I->comment("Exiting Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [deleteCustomStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteCustomStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteCustomStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "store" . msq("customStore")); // stepKey: fillStoreViewFilterFieldDeleteCustomStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteCustomStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteCustomStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteCustomStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteCustomStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteCustomStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteCustomStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteCustomStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteCustomStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteCustomStoreView
		$I->comment("Exiting Action Group [deleteCustomStoreView] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$disableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 0", 60); // stepKey: disableLoginAsCustomer
		$I->comment($disableLoginAsCustomer);
		$disableAddStoreCodeToUrls = $I->magentoCLI("config:set web/url/use_store 0", 60); // stepKey: disableAddStoreCodeToUrls
		$I->comment($disableAddStoreCodeToUrls);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
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
	 * @Stories({"Select Store based on 'Store View To Login In' setting"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginAsCustomerAutoDetectionTest(AcceptanceTester $I)
	{
		$I->comment("Login as Customer from Customer page");
		$I->comment("Entering Action Group [loginAsCustomerFromCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLoginAsCustomerFromCustomerPage
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLoginAsCustomerFromCustomerPageWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalLoginAsCustomerFromCustomerPage
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLoginAsCustomerFromCustomerPage
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(60); // stepKey: clickLoginLoginAsCustomerFromCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLoginAsCustomerFromCustomerPage
		$I->switchToNextTab(); // stepKey: switchToNewTabLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLoginAsCustomerFromCustomerPage
		$I->comment("Exiting Action Group [loginAsCustomerFromCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Assert Customer logged on on default store view");
		$I->comment("Entering Action Group [assertLoggedInFromCustomerGird] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->seeInCurrentUrl("/customer/account/"); // stepKey: assertOnCustomerAccountPageAssertLoggedInFromCustomerGird
		$I->see("Welcome, " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . "!", "header>.panel .greet.welcome"); // stepKey: assertCorrectWelcomeMessageAssertLoggedInFromCustomerGird
		$I->see($I->retrieveEntityField('createCustomer', 'email', 'test'), ".box.box-information .box-content"); // stepKey: assertCustomerEmailInContactInformationAssertLoggedInFromCustomerGird
		$I->comment("Exiting Action Group [assertLoggedInFromCustomerGird] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->comment("Entering Action Group [seeDefaultStoreCodeInUrl] AssertStorefrontStoreCodeInUrlActionGroup");
		$I->seeInCurrentUrl("/default"); // stepKey: seeStoreCodeInURLSeeDefaultStoreCodeInUrl
		$I->comment("Exiting Action Group [seeDefaultStoreCodeInUrl] AssertStorefrontStoreCodeInUrlActionGroup");
		$I->comment("Log out Customer and close tab");
		$I->comment("Entering Action Group [signOutAndCloseTab] StorefrontSignOutAndCloseTabActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonSignOutAndCloseTab
		$I->waitForElementVisible("div.customer-menu  li.authorization-link", 30); // stepKey: waitForSignOutSignOutAndCloseTab
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutSignOutAndCloseTab
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSignOutAndCloseTab
		$I->see("You are signed out"); // stepKey: signOutSignOutAndCloseTab
		$I->closeTab(); // stepKey: closeTabSignOutAndCloseTab
		$I->comment("Exiting Action Group [signOutAndCloseTab] StorefrontSignOutAndCloseTabActionGroup");
	}
}
