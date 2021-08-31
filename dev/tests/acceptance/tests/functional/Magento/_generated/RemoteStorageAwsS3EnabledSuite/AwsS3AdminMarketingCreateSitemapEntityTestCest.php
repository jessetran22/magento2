<?php
namespace Magento\AcceptanceTest\_RemoteStorageAwsS3EnabledSuite\Backend;

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
 * @Description("Sitemap Entity Creation<h3>Test files</h3>app/code/Magento/AwsS3/Test/Mftf/Test/AwsS3AdminMarketingCreateSitemapEntityTest.xml<br>")
 * @Title("MC-38319: AWS S3 Sitemap Creation")
 * @TestCaseId("MC-38319")
 * @group remote_storage_aws_s3
 */
class AwsS3AdminMarketingCreateSitemapEntityTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("BIC workaround");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteCreatedSitemap] AdminMarketingSiteDeleteByNameActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/sitemap/"); // stepKey: amOnSiteMapGridPageDeleteCreatedSitemap
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeleteCreatedSitemap
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteCreatedSitemap
		$I->fillField("#sitemapGrid_filter_sitemap_filename", "sitemap.xml"); // stepKey: fillFileNameFieldDeleteCreatedSitemap
		$I->waitForPageLoad(90); // stepKey: fillFileNameFieldDeleteCreatedSitemapWaitForPageLoad
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: clickSearchButtonDeleteCreatedSitemap
		$I->see("sitemap.xml", "#sitemapGrid_table>tbody>tr:nth-child(1)"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteCreatedSitemap
		$I->click("#sitemapGrid_table>tbody>tr:nth-child(1)"); // stepKey: clickEditExistingRowDeleteCreatedSitemap
		$I->waitForPageLoad(30); // stepKey: waitForSiteMapToLoadDeleteCreatedSitemap
		$I->click("#delete"); // stepKey: deleteSiteMapDeleteCreatedSitemap
		$I->waitForPageLoad(10); // stepKey: deleteSiteMapDeleteCreatedSitemapWaitForPageLoad
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxLoadDeleteCreatedSitemap
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteCreatedSitemap
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteCreatedSitemapWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteLoadDeleteCreatedSitemap
		$I->comment("Exiting Action Group [deleteCreatedSitemap] AdminMarketingSiteDeleteByNameActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->comment("BIC workaround");
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
	 * @Stories({"Admin Creates Sitemap Entity"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"AwsS3"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AwsS3AdminMarketingCreateSitemapEntityTest(AcceptanceTester $I)
	{
		$I->comment("TEST BODY");
		$I->comment("Navigate to Marketing->Sitemap Page");
		$I->comment("Entering Action Group [navigateToMarketingSiteMapPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToMarketingSiteMapPage
		$I->click("li[data-ui-id='menu-magento-backend-marketing']"); // stepKey: clickOnMenuItemNavigateToMarketingSiteMapPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToMarketingSiteMapPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-sitemap-catalog-sitemap']"); // stepKey: clickOnSubmenuItemNavigateToMarketingSiteMapPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToMarketingSiteMapPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToMarketingSiteMapPage] AdminNavigateMenuActionGroup");
		$I->comment("Navigate to New Sitemap Creation Page");
		$I->comment("Entering Action Group [navigateToAddNewSitemap] AdminMarketingNavigateToNewSitemapPageActionGroup");
		$I->click(".page-actions-buttons .add"); // stepKey: clickAddNewSitemapButtonNavigateToAddNewSitemap
		$I->waitForPageLoad(30); // stepKey: waitForNewNewsletterTemplatesPageLoadedNavigateToAddNewSitemap
		$I->comment("Exiting Action Group [navigateToAddNewSitemap] AdminMarketingNavigateToNewSitemapPageActionGroup");
		$I->comment("Create Sitemap Entity");
		$I->comment("Entering Action Group [createSitemap] AdminMarketingCreateSitemapEntityActionGroup");
		$I->fillField("#sitemap_filename", "sitemap.xml"); // stepKey: fillFilenameFieldCreateSitemap
		$I->fillField("#sitemap_path", "/"); // stepKey: fillPathFieldCreateSitemap
		$I->comment("Click the \"Save\" Button");
		$I->click(".page-actions .save"); // stepKey: clickSaveButtonCreateSitemap
		$I->comment("Exiting Action Group [createSitemap] AdminMarketingCreateSitemapEntityActionGroup");
		$I->comment("Assert Success Message");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleSeeSuccessMessage
		$I->see("You saved the sitemap.", "#messages div.message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Find Created Sitemap On Grid");
		$I->comment("Entering Action Group [findCreatedSitemapInGrid] AdminMarketingSearchSitemapActionGroup");
		$I->comment("Reset Search Filters");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedSitemapInGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedSitemapInGridWaitForPageLoad
		$I->comment("Fill Sitemap Name Field");
		$I->fillField("#sitemapGrid_filter_sitemap_filename", "sitemap.xml"); // stepKey: filterByNameFindCreatedSitemapInGrid
		$I->waitForPageLoad(90); // stepKey: filterByNameFindCreatedSitemapInGridWaitForPageLoad
		$I->comment("Click \"Search\" Button");
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: doFilterFindCreatedSitemapInGrid
		$I->waitForPageLoad(30); // stepKey: waitForSitemapPageLoadedAfterFilteringFindCreatedSitemapInGrid
		$I->comment("Exiting Action Group [findCreatedSitemapInGrid] AdminMarketingSearchSitemapActionGroup");
		$I->comment("Entering Action Group [assertSitemapInGrid] AssertAdminSitemapInGridActionGroup");
		$I->see("sitemap.xml", "tr[data-role='row']:nth-of-type(1)"); // stepKey: seeSitemapAssertSitemapInGrid
		$I->waitForPageLoad(30); // stepKey: seeSitemapAssertSitemapInGridWaitForPageLoad
		$I->comment("Exiting Action Group [assertSitemapInGrid] AssertAdminSitemapInGridActionGroup");
		$I->comment("END TEST BODY");
	}
}
