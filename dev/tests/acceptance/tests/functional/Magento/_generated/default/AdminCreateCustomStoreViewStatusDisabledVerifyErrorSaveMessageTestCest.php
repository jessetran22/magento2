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
 * @Title("MC-14309: Create Custom Store View Status Disabled and Verify Error Save Message")
 * @Description("Test log in to Stores and Create Custom Store View Status Enabled and Verify Error Save Message Test<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminCreateCustomStoreViewStatusDisabledVerifyErrorSaveMessageTest.xml<br>")
 * @TestCaseId("MC-14309")
 * @group store
 * @group mtf_migrated
 */
class AdminCreateCustomStoreViewStatusDisabledVerifyErrorSaveMessageTestCest
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
		$I->comment("Create website");
		$I->comment("Entering Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameCreateWebsite
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeCreateWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateWebsite
		$I->comment("Exiting Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Create store");
		$I->comment("Entering Action Group [createStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectWebsiteCreateStore
		$I->fillField("#group_name", "store" . msq("customStore")); // stepKey: enterStoreGroupNameCreateStore
		$I->fillField("#group_code", "store" . msq("customStore")); // stepKey: enterStoreGroupCodeCreateStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateStore
		$I->comment("Exiting Action Group [createStore] AdminCreateNewStoreGroupActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("Second Website" . msq("customWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
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
	public function AdminCreateCustomStoreViewStatusDisabledVerifyErrorSaveMessageTest(AcceptanceTester $I)
	{
		$I->comment("Create store view selecting store created, choose disabled status and verify AssertStoreDisabledErrorSaveMessage");
		$I->comment("Entering Action Group [createStoreViewAssertStoreDisabledErrorSaveMessage] StoreViewDisabledErrorSaveMessageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: amOnAdminSystemStoreViewPageCreateStoreViewAssertStoreDisabledErrorSaveMessage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCreateStoreViewAssertStoreDisabledErrorSaveMessage
		$I->selectOption("#store_group_id", "store" . msq("customStore")); // stepKey: selectStoreGroupCreateStoreViewAssertStoreDisabledErrorSaveMessage
		$I->fillField("#store_name", "storeViewDataDisabled"); // stepKey: fillStoreViewNameCreateStoreViewAssertStoreDisabledErrorSaveMessage
		$I->fillField("#store_code", "storeViewDataDisabled"); // stepKey: fillStoreViewCodeCreateStoreViewAssertStoreDisabledErrorSaveMessage
		$I->selectOption("#store_is_active", "0"); // stepKey: selectStoreViewStatusCreateStoreViewAssertStoreDisabledErrorSaveMessage
		$I->click("#save"); // stepKey: clickSaveStoreViewButtonCreateStoreViewAssertStoreDisabledErrorSaveMessage
		$I->waitForPageLoad(90); // stepKey: clickSaveStoreViewButtonCreateStoreViewAssertStoreDisabledErrorSaveMessageWaitForPageLoad
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForAcceptNewStoreViewCreationButtonCreateStoreViewAssertStoreDisabledErrorSaveMessage
		$I->conditionalClick(".action-primary.action-accept", ".action-primary.action-accept", true); // stepKey: clickAcceptNewStoreViewCreationButtonCreateStoreViewAssertStoreDisabledErrorSaveMessage
		$I->waitForElementVisible("//div[@class='message message-error error']/div", 30); // stepKey: waitForErrorMessageCreateStoreViewAssertStoreDisabledErrorSaveMessage
		$I->see("The default store cannot be disabled", "//div[@class='message message-error error']/div"); // stepKey: AssertStoreDisabledErrorSaveMessageCreateStoreViewAssertStoreDisabledErrorSaveMessage
		$I->comment("Exiting Action Group [createStoreViewAssertStoreDisabledErrorSaveMessage] StoreViewDisabledErrorSaveMessageActionGroup");
	}
}
