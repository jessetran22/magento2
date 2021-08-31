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
 * @Title("MC-14305: Create Store View Status Disabled and Verify Backend and Frontend")
 * @Description("Test log in to Stores and Create Store View Status Disabled Test<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminCreateStoreViewStatusDisabledVerifyBackendAndFrontendTest.xml<br>")
 * @TestCaseId("MC-14305")
 * @group store
 * @group mtf_migrated
 */
class AdminCreateStoreViewStatusDisabledVerifyBackendAndFrontendTestCest
{
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewDataDisabled")); // stepKey: fillStoreViewFilterFieldDeleteStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView
		$I->comment("Exiting Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
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
	 * @Stories({"Create Store View"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Store"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateStoreViewStatusDisabledVerifyBackendAndFrontendTest(AcceptanceTester $I)
	{
		$I->comment("Create store view");
		$I->comment("Entering Action Group [createStoreView] CreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: amOnAdminSystemStoreViewPageCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCreateStoreView
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreGroupCreateStoreView
		$I->fillField("#store_name", "storeView" . msq("storeViewDataDisabled")); // stepKey: fillStoreViewNameCreateStoreView
		$I->fillField("#store_code", "storeView" . msq("storeViewDataDisabled")); // stepKey: fillStoreViewCodeCreateStoreView
		$I->selectOption("#store_is_active", "0"); // stepKey: selectStoreViewStatusCreateStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewButtonCreateStoreView
		$I->waitForPageLoad(90); // stepKey: clickSaveStoreViewButtonCreateStoreViewWaitForPageLoad
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForAcceptNewStoreViewCreationButtonCreateStoreView
		$I->conditionalClick(".action-primary.action-accept", ".action-primary.action-accept", true); // stepKey: clickAcceptNewStoreViewCreationButtonCreateStoreView
		$I->see("You saved the store view."); // stepKey: seeSavedMessageCreateStoreView
		$I->comment("Exiting Action Group [createStoreView] CreateStoreViewActionGroup");
		$I->comment("Save the above store view and verify AssertStoreViewSuccessSaveMessage");
		$I->comment("Entering Action Group [verifyAssertStoreViewSuccessSaveMessage] AdminCreateStoreViewSaveActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForGridLoadVerifyAssertStoreViewSuccessSaveMessage
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReload2VerifyAssertStoreViewSuccessSaveMessage
		$I->see("You saved the store view."); // stepKey: seeSavedMessageVerifyAssertStoreViewSuccessSaveMessage
		$I->comment("Exiting Action Group [verifyAssertStoreViewSuccessSaveMessage] AdminCreateStoreViewSaveActionGroup");
		$I->comment("Go to store configuration page and verify AssertStoreBackend");
		$I->comment("Entering Action Group [verifyValuesOnStoreBackend] AssertStoreConfigurationBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/"); // stepKey: goToConfigStoreConfigurationPageVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: waitForSystemStoreConfigurationPageLoadVerifyValuesOnStoreBackend
		$I->click("#store-change-button"); // stepKey: clickDefaultConfigButtonVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: clickDefaultConfigButtonVerifyValuesOnStoreBackendWaitForPageLoad
		$I->see("", "//ul[@class='dropdown-menu']"); // stepKey: seeAssertWebsiteInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertWebsiteInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->see("", "//ul[@class='dropdown-menu']"); // stepKey: seeAssertSecondStoreInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertSecondStoreInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->see("storeView" . msq("storeViewDataDisabled"), "//ul[@class='dropdown-menu']"); // stepKey: seeAssertFirstStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertFirstStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->see("", "//ul[@class='dropdown-menu']"); // stepKey: seeAssertSecondStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertSecondStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->comment("Exiting Action Group [verifyValuesOnStoreBackend] AssertStoreConfigurationBackendActionGroup");
		$I->comment("Go to storefront and verify AssertStoreNotOnFrontend");
		$I->comment("Entering Action Group [verifyValuesNotOnStorefront] AssertStorefrontStoreNotVisibleInFooterActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageVerifyValuesNotOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontHomePageLoadVerifyValuesNotOnStorefront
		$I->dontSee("//ul[@class='dropdown switcher-dropdown']//a[contains(text(),'{{storeViewDataDisabled.name}')]"); // stepKey: AssertStoreNotOnStorefrontVerifyValuesNotOnStorefront
		$I->waitForPageLoad(30); // stepKey: AssertStoreNotOnStorefrontVerifyValuesNotOnStorefrontWaitForPageLoad
		$I->comment("Exiting Action Group [verifyValuesNotOnStorefront] AssertStorefrontStoreNotVisibleInFooterActionGroup");
	}
}
