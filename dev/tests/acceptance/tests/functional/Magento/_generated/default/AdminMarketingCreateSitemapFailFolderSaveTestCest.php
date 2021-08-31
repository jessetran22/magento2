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
 * @Title("MC-14314: Sitemap Creation Fail Folder Save")
 * @Description("Sitemap Entity Creation Fail Folder Save<h3>Test files</h3>app/code/Magento/Sitemap/Test/Mftf/Test/AdminMarketingCreateSitemapFailFolderSaveTest.xml<br>")
 * @TestCaseId("MC-14314")
 * @group sitemap
 * @group mtf_migrated
 */
class AdminMarketingCreateSitemapFailFolderSaveTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Admin Creates Sitemap Entity Fail Folder Save"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMarketingCreateSitemapFailFolderSaveTest(AcceptanceTester $I)
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
		$I->comment("Create Sitemap Entity With Incorrect Folder");
		$I->comment("Entering Action Group [createSitemap] AdminMarketingCreateSitemapEntityActionGroup");
		$I->fillField("#sitemap_filename", "sitemap.xml"); // stepKey: fillFilenameFieldCreateSitemap
		$I->fillField("#sitemap_path", "%isolation%"); // stepKey: fillPathFieldCreateSitemap
		$I->comment("Click the \"Save\" Button");
		$I->click(".page-actions .save"); // stepKey: clickSaveButtonCreateSitemap
		$I->comment("Exiting Action Group [createSitemap] AdminMarketingCreateSitemapEntityActionGroup");
		$I->comment("See Error Message");
		$I->comment("Entering Action Group [seeErrorMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleSeeErrorMessage
		$I->see("Please create the specified folder \"%isolation%\" before saving the sitemap.", "#messages div.message-error"); // stepKey: verifyMessageSeeErrorMessage
		$I->comment("Exiting Action Group [seeErrorMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("END TEST BODY");
	}
}
