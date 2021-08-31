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
 * @Title("MC-14650: Delete CMS Page URL rewrite with Temporary Redirect")
 * @Description("Log in to admin and delete CMS Page URL rewrite with Temporary Redirect<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminDeleteCmsPageUrlRewriteWithTemporaryRedirectTest.xml<br>")
 * @TestCaseId("MC-14650")
 * @group mtf_migrated
 */
class AdminDeleteCmsPageUrlRewriteWithTemporaryRedirectTestCest
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
		$I->createEntity("createCMSPage", "hook", "simpleCmsPage", [], []); // stepKey: createCMSPage
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCMSPage", "hook"); // stepKey: deleteCMSPage
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
	 * @Stories({"Delete CMS Page URL rewrite with Temporary Redirect"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"UrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteCmsPageUrlRewriteWithTemporaryRedirectTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openUrlRewriteEditPage] AdminGoToAddNewUrlRewritePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/edit/id/"); // stepKey: openUrlRewriteEditPageOpenUrlRewriteEditPage
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadOpenUrlRewriteEditPage
		$I->comment("Exiting Action Group [openUrlRewriteEditPage] AdminGoToAddNewUrlRewritePageActionGroup");
		$I->comment("Entering Action Group [selectForCsmPageType] AdminCreateNewUrlRewriteForCmsPageActionGroup");
		$I->click("//select[@id='entity-type-selector']"); // stepKey: clickOnCustomUrlRewriteSelectForCsmPageType
		$I->click("//select[@id='entity-type-selector']/option[contains(.,'For CMS page')]"); // stepKey: selectForCsmPageSelectForCsmPageType
		$I->waitForPageLoad(30); // stepKey: waitForCategoryEditSectionToLoadSelectForCsmPageType
		$I->comment("Exiting Action Group [selectForCsmPageType] AdminCreateNewUrlRewriteForCmsPageActionGroup");
		$I->comment("Entering Action Group [selectCmsPge] AdminSelectCmsPageFromGridForNewUrlRewriteActionGroup");
		$I->click("//td[contains(text(), '" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "')]"); // stepKey: selectCmsPageSelectCmsPge
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSelectCmsPge
		$I->comment("Exiting Action Group [selectCmsPge] AdminSelectCmsPageFromGridForNewUrlRewriteActionGroup");
		$I->comment("Entering Action Group [fillTheForm] AdminFillNewCmsPageUrlRewriteFormActionGroup");
		$I->click("//select[@id='store_id']"); // stepKey: clickOnStoreFillTheForm
		$I->click("//select[@id='store_id']//option[contains(., 'Default Store View')]"); // stepKey: clickOnStoreValueFillTheForm
		$I->fillField("//input[@id='request_path']", "temporaryrequestpath.html"); // stepKey: fillRequestPathFillTheForm
		$I->click("//select[@id='redirect_type']"); // stepKey: selectRedirectTypeFillTheForm
		$I->click("//select[@id='redirect_type']//option[contains(., 'Temporary (302)')]"); // stepKey: clickOnRedirectTypeValueFillTheForm
		$I->fillField("#description", "cms_default_temporary_redirect"); // stepKey: fillDescriptionFillTheForm
		$I->click("#save"); // stepKey: clickOnSaveButtonFillTheForm
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonFillTheFormWaitForPageLoad
		$I->comment("Exiting Action Group [fillTheForm] AdminFillNewCmsPageUrlRewriteFormActionGroup");
		$I->comment("Delete the URL Rewrite for CMS Page with with temporary redirect");
		$I->comment("Entering Action Group [deleteTemporaryUrlRewrite] AdminDeleteUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageDeleteTemporaryUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadDeleteTemporaryUrlRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteTemporaryUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteTemporaryUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteTemporaryUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersDeleteTemporaryUrlRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersDeleteTemporaryUrlRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "temporaryrequestpath.html"); // stepKey: fillRedirectPathFilterDeleteTemporaryUrlRewrite
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersDeleteTemporaryUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersDeleteTemporaryUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1DeleteTemporaryUrlRewrite
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//button[contains(@class, 'action-select')]"); // stepKey: clickOnRowSelectButtonDeleteTemporaryUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnRowSelectButtonDeleteTemporaryUrlRewriteWaitForPageLoad
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//a[contains(., 'Edit')]"); // stepKey: clickOnEditButtonDeleteTemporaryUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnEditButtonDeleteTemporaryUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForEditPageToLoadDeleteTemporaryUrlRewrite
		$I->click("#delete"); // stepKey: clickOnDeleteButtonDeleteTemporaryUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteButtonDeleteTemporaryUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad2DeleteTemporaryUrlRewrite
		$I->waitForElementVisible("//button[@class='action-primary action-accept']", 30); // stepKey: waitForOkButtonToVisibleDeleteTemporaryUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForOkButtonToVisibleDeleteTemporaryUrlRewriteWaitForPageLoad
		$I->click("//button[@class='action-primary action-accept']"); // stepKey: clickOnOkButtonDeleteTemporaryUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnOkButtonDeleteTemporaryUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad3DeleteTemporaryUrlRewrite
		$I->see("You deleted the URL rewrite.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteTemporaryUrlRewrite
		$I->comment("Exiting Action Group [deleteTemporaryUrlRewrite] AdminDeleteUrlRewriteActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessage
		$I->see("You deleted the URL rewrite.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Verify AssertPageByUrlRewriteIsNotFound");
		$I->comment("Entering Action Group [assertPageByUrlRewriteIsNotFound] AssertPageByUrlRewriteIsNotFoundActionGroup");
		$I->amOnPage("temporaryrequestpath.html"); // stepKey: amOnPageAssertPageByUrlRewriteIsNotFound
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAssertPageByUrlRewriteIsNotFound
		$I->see("Whoops, our bad..."); // stepKey: seeWhoopsAssertPageByUrlRewriteIsNotFound
		$I->comment("Exiting Action Group [assertPageByUrlRewriteIsNotFound] AssertPageByUrlRewriteIsNotFoundActionGroup");
	}
}
