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
 * @Title("MC-14315: Sitemap Deleting Test")
 * @Description("Admin Should Delete Sitemap Entity<h3>Test files</h3>app/code/Magento/Sitemap/Test/Mftf/Test/AdminMarketingDeleteSitemapEntityTest.xml<br>")
 * @TestCaseId("MC-14315")
 * @group sitemap
 * @group mtf_migrated
 */
class AdminMarketingDeleteSitemapEntityTestCest
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
		$I->comment("Navigate to Marketing->Sitemap Page");
		$I->comment("Entering Action Group [navigateToMarketingSiteMapPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToMarketingSiteMapPage
		$I->click("li[data-ui-id='menu-magento-backend-marketing']"); // stepKey: clickOnMenuItemNavigateToMarketingSiteMapPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToMarketingSiteMapPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-sitemap-catalog-sitemap']"); // stepKey: clickOnSubmenuItemNavigateToMarketingSiteMapPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToMarketingSiteMapPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToMarketingSiteMapPage] AdminNavigateMenuActionGroup");
		$I->comment("Navigate To New Sitemap Page");
		$I->comment("Entering Action Group [navigateToNewSitemapPage] AdminMarketingSiteMapNavigateNewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/sitemap/new/"); // stepKey: openNewSiteMapPageNavigateToNewSitemapPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToNewSitemapPage
		$I->comment("Exiting Action Group [navigateToNewSitemapPage] AdminMarketingSiteMapNavigateNewActionGroup");
		$I->comment("Create Sitemap Entity");
		$I->comment("Entering Action Group [createSitemap] AdminMarketingSiteMapFillFormActionGroup");
		$I->fillField("input[name='sitemap_filename']", msq("UniqueSitemapName") . "sitemap.xml"); // stepKey: fillFilenameCreateSitemap
		$I->fillField("input[name='sitemap_path']", "/"); // stepKey: fillPathCreateSitemap
		$I->click("#save"); // stepKey: saveSiteMapCreateSitemap
		$I->waitForPageLoad(10); // stepKey: saveSiteMapCreateSitemapWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCreateSitemap
		$I->comment("Exiting Action Group [createSitemap] AdminMarketingSiteMapFillFormActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
	 * @Features({"Sitemap"})
	 * @Stories({"Admin Deletes Sitemap Entity Test"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMarketingDeleteSitemapEntityTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteCreatedSitemap] AdminMarketingSiteDeleteByNameActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/sitemap/"); // stepKey: amOnSiteMapGridPageDeleteCreatedSitemap
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeleteCreatedSitemap
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteCreatedSitemap
		$I->fillField("#sitemapGrid_filter_sitemap_filename", msq("UniqueSitemapName") . "sitemap.xml"); // stepKey: fillFileNameFieldDeleteCreatedSitemap
		$I->waitForPageLoad(90); // stepKey: fillFileNameFieldDeleteCreatedSitemapWaitForPageLoad
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: clickSearchButtonDeleteCreatedSitemap
		$I->see(msq("UniqueSitemapName") . "sitemap.xml", "#sitemapGrid_table>tbody>tr:nth-child(1)"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteCreatedSitemap
		$I->click("#sitemapGrid_table>tbody>tr:nth-child(1)"); // stepKey: clickEditExistingRowDeleteCreatedSitemap
		$I->waitForPageLoad(30); // stepKey: waitForSiteMapToLoadDeleteCreatedSitemap
		$I->click("#delete"); // stepKey: deleteSiteMapDeleteCreatedSitemap
		$I->waitForPageLoad(10); // stepKey: deleteSiteMapDeleteCreatedSitemapWaitForPageLoad
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxLoadDeleteCreatedSitemap
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteCreatedSitemap
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteCreatedSitemapWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteLoadDeleteCreatedSitemap
		$I->comment("Exiting Action Group [deleteCreatedSitemap] AdminMarketingSiteDeleteByNameActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertSiteMapDeleteSuccessActionGroup");
		$I->see("You deleted the sitemap.", "#messages div.message-success"); // stepKey: seeSuccessAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertSiteMapDeleteSuccessActionGroup");
		$I->comment("Entering Action Group [searchDeletedSitemap] AdminMarketingSitemapSearchActionGroup");
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterSearchDeletedSitemap
		$I->fillField("#sitemapGrid_filter_sitemap_filename", msq("UniqueSitemapName") . "sitemap.xml"); // stepKey: fillFileNameFieldSearchDeletedSitemap
		$I->waitForPageLoad(90); // stepKey: fillFileNameFieldSearchDeletedSitemapWaitForPageLoad
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: clickSearchButtonSearchDeletedSitemap
		$I->comment("Exiting Action Group [searchDeletedSitemap] AdminMarketingSitemapSearchActionGroup");
		$I->comment("Entering Action Group [dontSeeEntity] AssertAdminSitemapIsNotInGridActionGroup");
		$I->dontSee(msq("UniqueSitemapName") . "sitemap.xml", "#sitemapGrid_table>tbody>tr:nth-child(1)"); // stepKey: verifyThatCorrectStoreGroupFoundDontSeeEntity
		$I->comment("Exiting Action Group [dontSeeEntity] AssertAdminSitemapIsNotInGridActionGroup");
	}
}
