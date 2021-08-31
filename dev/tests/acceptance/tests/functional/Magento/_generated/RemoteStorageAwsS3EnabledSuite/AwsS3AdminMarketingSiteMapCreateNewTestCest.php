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
 * @Title("MC-38320: AWS S3 Create New Site Map with valid data")
 * @Description("Create New Site Map with valid data<h3>Test files</h3>app/code/Magento/AwsS3/Test/Mftf/Test/AwsS3AdminMarketingSiteMapCreateNewTest.xml<br>")
 * @TestCaseId("MC-38320")
 * @group remote_storage_aws_s3
 */
class AwsS3AdminMarketingSiteMapCreateNewTestCest
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
        $this->helperContainer->create("\Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions");
        $this->helperContainer->create("Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
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
		$I->comment("BIC workaround");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteSiteMap] AdminMarketingSiteDeleteByNameActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/sitemap/"); // stepKey: amOnSiteMapGridPageDeleteSiteMap
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeleteSiteMap
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteSiteMap
		$I->fillField("#sitemapGrid_filter_sitemap_filename", "sitemap.xml"); // stepKey: fillFileNameFieldDeleteSiteMap
		$I->waitForPageLoad(90); // stepKey: fillFileNameFieldDeleteSiteMapWaitForPageLoad
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: clickSearchButtonDeleteSiteMap
		$I->see("sitemap.xml", "#sitemapGrid_table>tbody>tr:nth-child(1)"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteSiteMap
		$I->click("#sitemapGrid_table>tbody>tr:nth-child(1)"); // stepKey: clickEditExistingRowDeleteSiteMap
		$I->waitForPageLoad(30); // stepKey: waitForSiteMapToLoadDeleteSiteMap
		$I->click("#delete"); // stepKey: deleteSiteMapDeleteSiteMap
		$I->waitForPageLoad(10); // stepKey: deleteSiteMapDeleteSiteMapWaitForPageLoad
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxLoadDeleteSiteMap
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteSiteMap
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteSiteMapWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteLoadDeleteSiteMap
		$I->comment("Exiting Action Group [deleteSiteMap] AdminMarketingSiteDeleteByNameActionGroup");
		$I->comment("Entering Action Group [assertDeleteSuccessMessage] AssertSiteMapDeleteSuccessActionGroup");
		$I->see("You deleted the sitemap.", "#messages div.message-success"); // stepKey: seeSuccessAssertDeleteSuccessMessage
		$I->comment("Exiting Action Group [assertDeleteSuccessMessage] AssertSiteMapDeleteSuccessActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Create Site Map"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"AwsS3"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AwsS3AdminMarketingSiteMapCreateNewTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateNewSiteMap] AdminMarketingSiteMapNavigateNewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/sitemap/new/"); // stepKey: openNewSiteMapPageNavigateNewSiteMap
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateNewSiteMap
		$I->comment("Exiting Action Group [navigateNewSiteMap] AdminMarketingSiteMapNavigateNewActionGroup");
		$I->comment("Entering Action Group [fillSiteMapForm] AdminMarketingSiteMapFillFormActionGroup");
		$I->fillField("input[name='sitemap_filename']", "sitemap.xml"); // stepKey: fillFilenameFillSiteMapForm
		$I->fillField("input[name='sitemap_path']", "/"); // stepKey: fillPathFillSiteMapForm
		$I->click("#save"); // stepKey: saveSiteMapFillSiteMapForm
		$I->waitForPageLoad(10); // stepKey: saveSiteMapFillSiteMapFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFillSiteMapForm
		$I->comment("Exiting Action Group [fillSiteMapForm] AdminMarketingSiteMapFillFormActionGroup");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertSiteMapCreateSuccessActionGroup");
		$I->see("You saved the sitemap.", "#messages div.message-success"); // stepKey: seeSuccessSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertSiteMapCreateSuccessActionGroup");
	}
}
