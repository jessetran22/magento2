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
 * @Title("[NO TESTCASEID]: Check 'Store view' sort order values")
 * @Description("Check 'Store View' sort order values no frontend store-switcher<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/StorefrontCheckSortOrderStoreViewTest.xml<br>")
 * @group store
 */
class StorefrontCheckSortOrderStoreViewCest
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
		$I->comment("Entering Action Group [createFirstStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateFirstStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateFirstStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectWebsiteCreateFirstStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupNameCreateFirstStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupCodeCreateFirstStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateFirstStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateFirstStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateFirstStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateFirstStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateFirstStore
		$I->comment("Exiting Action Group [createFirstStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Entering Action Group [createSecondStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateSecondStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectWebsiteCreateSecondStore
		$I->fillField("#group_name", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupNameCreateSecondStore
		$I->fillField("#group_code", "second_store_" . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupCodeCreateSecondStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateSecondStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateSecondStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateSecondStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateSecondStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateSecondStore
		$I->comment("Exiting Action Group [createSecondStore] AdminCreateNewStoreGroupActionGroup");
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
		$I->comment("Entering Action Group [deleteSecondStore] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteSecondStore
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteSecondStore
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteSecondStoreWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: fillSearchStoreGroupFieldDeleteSecondStore
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteSecondStore
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteSecondStoreWaitForPageLoad
		$I->see("Second Store " . msq("SecondStoreGroupUnique"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteSecondStore
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteSecondStore
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteSecondStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteSecondStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteSecondStoreWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteSecondStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteSecondStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteSecondStoreWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteSecondStore
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteSecondStore
		$I->comment("Exiting Action Group [deleteSecondStore] DeleteCustomStoreActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Features({"Store"})
	 * @Stories({"Github issue: #13401 'Store View' sort order values are not reflected"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckSortOrderStoreView(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [createFirstStoreView] AdminCreateStoreViewFillSortOrderActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateFirstStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateFirstStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateFirstStoreView
		$I->fillField("#store_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreViewNameCreateFirstStoreView
		$I->fillField("#store_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreViewCodeCreateFirstStoreView
		$I->fillField("#store_sort_order", "30"); // stepKey: fillSortOrderCreateFirstStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateFirstStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateFirstStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateFirstStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateFirstStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateFirstStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateFirstStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateFirstStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateFirstStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateFirstStoreView
		$I->comment("Exiting Action Group [createFirstStoreView] AdminCreateStoreViewFillSortOrderActionGroup");
		$I->comment("Entering Action Group [createSecondStoreView] AdminCreateStoreViewFillSortOrderActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: selectStoreCreateSecondStoreView
		$I->fillField("#store_name", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: enterStoreViewNameCreateSecondStoreView
		$I->fillField("#store_code", "second_store_" . msq("SecondStoreGroupUnique")); // stepKey: enterStoreViewCodeCreateSecondStoreView
		$I->fillField("#store_sort_order", "20"); // stepKey: fillSortOrderCreateSecondStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateSecondStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateSecondStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateSecondStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateSecondStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateSecondStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateSecondStoreView
		$I->comment("Exiting Action Group [createSecondStoreView] AdminCreateStoreViewFillSortOrderActionGroup");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->click("#switcher-store-trigger"); // stepKey: selectStoreSwitcher
		$grabSwatchFirstOption = $I->grabTextFrom("//div[@class='actions dropdown options switcher-options active']//ul//li[1]//a"); // stepKey: grabSwatchFirstOption
		$grabSwatchSecondOption = $I->grabTextFrom("//div[@class='actions dropdown options switcher-options active']//ul//li[2]//a"); // stepKey: grabSwatchSecondOption
		$I->assertStringContainsString("Second Store " . msq("SecondStoreGroupUnique"), $grabSwatchFirstOption); // stepKey: checkingSwatchFirstOption
		$I->assertStringContainsString("store" . msq("customStoreGroup"), $grabSwatchSecondOption); // stepKey: checkingSwatchSecondOption
	}
}
