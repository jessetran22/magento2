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
 * @Title("MC-14301: Update Website and Verify Store Form")
 * @Description("Test log in to Stores and Update Website Test<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminUpdateWebsiteTest.xml<br>")
 * @TestCaseId("MC-14301")
 * @group store
 * @group mtf_migrated
 */
class AdminUpdateWebsiteTestCest
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
		$I->fillField("#storeGrid_filter_website_title", "website_upd" . msq("updateCustomWebsite")); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("website_upd" . msq("updateCustomWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
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
	 * @Stories({"Update Website"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Store"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateWebsiteTest(AcceptanceTester $I)
	{
		$I->comment("Search created custom website in grid");
		$I->comment("Entering Action Group [seeWebsiteInGrid] AssertWebsiteInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageSeeWebsiteInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadSeeWebsiteInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterSeeWebsiteInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterSeeWebsiteInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillWebsiteFieldSeeWebsiteInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonSeeWebsiteInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSeeWebsiteInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadSeeWebsiteInGrid
		$I->seeElement("//td[@class='a-left col-website_title  ']/a[contains(.,'Second Website" . msq("customWebsite") . "')]"); // stepKey: seeAssertWebsiteInGridSeeWebsiteInGrid
		$I->comment("Exiting Action Group [seeWebsiteInGrid] AssertWebsiteInGridActionGroup");
		$I->click("//td[@class='a-left col-website_title  ']/a[contains(.,'Second Website" . msq("customWebsite") . "')]"); // stepKey: clickWebsiteFirstRowInGrid
		$I->waitForPageLoad(30); // stepKey: waitForWebsiteFormPageToOpen
		$I->comment("Update website name and website code as per data created and verify AssertWebsiteSuccessSaveMessage");
		$I->comment("Entering Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "website_upd" . msq("updateCustomWebsite")); // stepKey: enterWebsiteNameCreateWebsite
		$I->fillField("#website_code", "code_upd" . msq("updateCustomWebsite")); // stepKey: enterWebsiteCodeCreateWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateWebsite
		$I->comment("Exiting Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Search updated custom website(from above step) in grid and verify AssertWebsiteInGrid");
		$I->comment("Entering Action Group [seeUpdatedWebsiteInGrid] AssertWebsiteInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageSeeUpdatedWebsiteInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadSeeUpdatedWebsiteInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterSeeUpdatedWebsiteInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterSeeUpdatedWebsiteInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "website_upd" . msq("updateCustomWebsite")); // stepKey: fillWebsiteFieldSeeUpdatedWebsiteInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonSeeUpdatedWebsiteInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSeeUpdatedWebsiteInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadSeeUpdatedWebsiteInGrid
		$I->seeElement("//td[@class='a-left col-website_title  ']/a[contains(.,'website_upd" . msq("updateCustomWebsite") . "')]"); // stepKey: seeAssertWebsiteInGridSeeUpdatedWebsiteInGrid
		$I->comment("Exiting Action Group [seeUpdatedWebsiteInGrid] AssertWebsiteInGridActionGroup");
		$I->comment("Verify updated website name and updated websitecode on website form (AssertWebsiteForm and AssertWebsiteOnStoreForm)");
		$I->comment("Entering Action Group [seeUpdatedWebsiteForm] AssertWebsiteFormActionGroup");
		$I->click("//td[@class='a-left col-website_title  ']/a[contains(.,'website_upd" . msq("updateCustomWebsite") . "')]"); // stepKey: clickWebsiteFirstRowInGridSeeUpdatedWebsiteForm
		$I->waitForPageLoad(30); // stepKey: waitTillWebsiteFormPageIsOpenedSeeUpdatedWebsiteForm
		$grabWebsiteIdFromCurrentUrlSeeUpdatedWebsiteForm = $I->grabFromCurrentUrl("~(\d+)/~"); // stepKey: grabWebsiteIdFromCurrentUrlSeeUpdatedWebsiteForm
		$I->seeInCurrentUrl("/system_store/editWebsite/website_id/{$grabWebsiteIdFromCurrentUrlSeeUpdatedWebsiteForm}"); // stepKey: seeWebsiteIdSeeUpdatedWebsiteForm
		$I->seeInField("#website_name", "website_upd" . msq("updateCustomWebsite")); // stepKey: seeAssertWebsiteNameSeeUpdatedWebsiteForm
		$I->seeInField("#website_code", "code_upd" . msq("updateCustomWebsite")); // stepKey: seeAssertWebsiteCodeSeeUpdatedWebsiteForm
		$I->comment("Exiting Action Group [seeUpdatedWebsiteForm] AssertWebsiteFormActionGroup");
	}
}
