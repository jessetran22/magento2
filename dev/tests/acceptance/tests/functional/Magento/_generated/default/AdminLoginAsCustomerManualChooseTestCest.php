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
 * @Title("[NO TESTCASEID]: Admin user directly login into customer account with store View To Login In = Manual Choose")
 * @Description("Verify admin user can directly login into customer account to Custom store view when Store View To Login In = Manual Choose<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/AdminLoginAsCustomerManualChooseTest.xml<br>")
 * @group login_as_customer
 */
class AdminLoginAsCustomerManualChooseTestCest
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
		$enableLoginAsCustomerManualChoose = $I->magentoCLI("config:set login_as_customer/general/store_view_manual_choice_enabled 1", 60); // stepKey: enableLoginAsCustomerManualChoose
		$I->comment($enableLoginAsCustomerManualChoose);
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
		$I->comment("Entering Action Group [createCustomStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateCustomStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateCustomStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectWebsiteCreateCustomStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupNameCreateCustomStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupCodeCreateCustomStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateCustomStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateCustomStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateCustomStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateCustomStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateCustomStore
		$I->comment("Exiting Action Group [createCustomStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Entering Action Group [createFirstCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateFirstCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateFirstCustomStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateFirstCustomStoreView
		$I->fillField("#store_name", "EN" . msq("customStoreEN")); // stepKey: enterStoreViewNameCreateFirstCustomStoreView
		$I->fillField("#store_code", "en" . msq("customStoreEN")); // stepKey: enterStoreViewCodeCreateFirstCustomStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateFirstCustomStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateFirstCustomStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateFirstCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateFirstCustomStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateFirstCustomStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateFirstCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateFirstCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateFirstCustomStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateFirstCustomStoreView
		$I->comment("Exiting Action Group [createFirstCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [createSecondCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateSecondCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondCustomStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateSecondCustomStoreView
		$I->fillField("#store_name", "FR" . msq("customStoreFR")); // stepKey: enterStoreViewNameCreateSecondCustomStoreView
		$I->fillField("#store_code", "fr" . msq("customStoreFR")); // stepKey: enterStoreViewCodeCreateSecondCustomStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateSecondCustomStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateSecondCustomStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateSecondCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateSecondCustomStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateSecondCustomStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateSecondCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateSecondCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateSecondCustomStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateSecondCustomStoreView
		$I->comment("Exiting Action Group [createSecondCustomStoreView] AdminCreateStoreViewActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteCustomStore] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteCustomStore
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteCustomStore
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteCustomStoreWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStoreGroup")); // stepKey: fillSearchStoreGroupFieldDeleteCustomStore
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteCustomStore
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteCustomStoreWaitForPageLoad
		$I->see("store" . msq("customStoreGroup"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteCustomStore
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteCustomStore
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteCustomStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteCustomStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteCustomStoreWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteCustomStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteCustomStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteCustomStoreWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteCustomStore
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomStore
		$I->comment("Exiting Action Group [deleteCustomStore] DeleteCustomStoreActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$disableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 0", 60); // stepKey: disableLoginAsCustomer
		$I->comment($disableLoginAsCustomer);
		$enableLoginAsCustomerAutoDetection = $I->magentoCLI("config:set login_as_customer/general/store_view_manual_choice_enabled 0", 60); // stepKey: enableLoginAsCustomerAutoDetection
		$I->comment($enableLoginAsCustomerAutoDetection);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginAsCustomerManualChooseTest(AcceptanceTester $I)
	{
		$I->comment("Login as Customer from Customer page");
		$I->comment("Entering Action Group [loginAsCustomerFromCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageManualChooseActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLoginAsCustomerFromCustomerPage
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLoginAsCustomerFromCustomerPageWaitForPageLoad
		$I->see("Login as Customer: Select Store", "aside.confirm .modal-title"); // stepKey: seeModalLoginAsCustomerFromCustomerPage
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLoginAsCustomerFromCustomerPage
		$I->selectOption("//select[@id='lac-confirmation-popup-store-id']", "store" . msq("customStoreGroup")); // stepKey: selectStoreLoginAsCustomerFromCustomerPage
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(60); // stepKey: clickLoginLoginAsCustomerFromCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLoginAsCustomerFromCustomerPage
		$I->switchToNextTab(); // stepKey: switchToNewTabLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLoginAsCustomerFromCustomerPage
		$I->comment("Exiting Action Group [loginAsCustomerFromCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageManualChooseActionGroup");
		$I->comment("Assert Customer logged on on custom store view");
		$I->comment("Entering Action Group [assertLoggedInFromCustomerGird] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->seeInCurrentUrl("/customer/account/"); // stepKey: assertOnCustomerAccountPageAssertLoggedInFromCustomerGird
		$I->see("Welcome, " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . "!", "header>.panel .greet.welcome"); // stepKey: assertCorrectWelcomeMessageAssertLoggedInFromCustomerGird
		$I->see($I->retrieveEntityField('createCustomer', 'email', 'test'), ".box.box-information .box-content"); // stepKey: assertCustomerEmailInContactInformationAssertLoggedInFromCustomerGird
		$I->comment("Exiting Action Group [assertLoggedInFromCustomerGird] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->comment("Entering Action Group [assertCustomStoreView] StorefrontAssertCustomerOnStoreViewActionGroup");
		$I->see("EN" . msq("customStoreEN"), "#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherAssertCustomStoreView
		$I->comment("Exiting Action Group [assertCustomStoreView] StorefrontAssertCustomerOnStoreViewActionGroup");
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
