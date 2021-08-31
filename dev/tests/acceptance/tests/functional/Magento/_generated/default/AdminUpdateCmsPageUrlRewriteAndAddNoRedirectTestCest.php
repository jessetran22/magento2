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
 * @Title(": Update Cms Page URL Rewrites, no redirect type")
 * @Description("Login as Admin and update Cms Page Url Rewrite and add redirect type No<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminUpdateCmsPageUrlRewriteAndAddNoRedirectTest.xml<br>")
 * @TestCaseId("")
 * @group mtf_migrated
 */
class AdminUpdateCmsPageUrlRewriteAndAddNoRedirectTestCest
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
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->createEntity("createCMSPage", "hook", "simpleCmsPage", [], []); // stepKey: createCMSPage
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
	 * @Stories({"Update URL rewrite"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"UrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateCmsPageUrlRewriteAndAddNoRedirectTest(AcceptanceTester $I)
	{
		$I->comment("Open CMS Edit Page and Get the CMS ID");
		$I->comment("Entering Action Group [navigateToCreatedCMSPage] NavigateToCreatedCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCreatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSPage
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSPage
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCreatedCMSPageNavigateToCreatedCMSPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: navigateToCreatedCMSPageNavigateToCreatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSPage
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageNavigateToCreatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSPage
		$I->comment("Exiting Action Group [navigateToCreatedCMSPage] NavigateToCreatedCMSPageActionGroup");
		$cmsId = $I->grabFromCurrentUrl("#\/([0-9]*)?\/$#"); // stepKey: cmsId
		$I->comment("Search and Select Edit option for created cms page in grid");
		$I->comment("Entering Action Group [editUrlRewrite] AdminSearchAndSelectUrlRewriteInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadEditUrlRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersEditUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadEditUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersEditUrlRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createCMSPage', 'identifier', 'test')); // stepKey: fillRequestPathFilterEditUrlRewrite
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersEditUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1EditUrlRewrite
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//button[contains(@class, 'action-select')]"); // stepKey: clickOnRowSelectButtonEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnRowSelectButtonEditUrlRewriteWaitForPageLoad
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//a[contains(., 'Edit')]"); // stepKey: clickOnEditButtonEditUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnEditButtonEditUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForEditPageToLoadEditUrlRewrite
		$I->comment("Exiting Action Group [editUrlRewrite] AdminSearchAndSelectUrlRewriteInGridActionGroup");
		$I->comment("Open UrlRewrite Edit page and update the fields");
		$I->comment("Entering Action Group [updateCmsPageUrlRewrite] AdminUpdateUrlRewriteActionGroup");
		$I->click("//select[@id='store_id']"); // stepKey: clickOnStoreUpdateCmsPageUrlRewrite
		$I->click("//select[@id='store_id']//option[contains(., 'Default Store View')]"); // stepKey: clickOnStoreValueUpdateCmsPageUrlRewrite
		$I->fillField("//input[@id='request_path']", "CMSpage" . msq("defaultCmsPage")); // stepKey: fillRequestPathUpdateCmsPageUrlRewrite
		$I->click("//select[@id='redirect_type']"); // stepKey: selectRedirectTypeUpdateCmsPageUrlRewrite
		$I->click("//select[@id='redirect_type']//option[contains(., 'No')]"); // stepKey: selectRedirectTypeValueUpdateCmsPageUrlRewrite
		$I->fillField("#description", "Update Cms Page Url Rewrite"); // stepKey: fillDescriptionUpdateCmsPageUrlRewrite
		$I->click("#save"); // stepKey: clickOnSaveButtonUpdateCmsPageUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonUpdateCmsPageUrlRewriteWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessSaveMessageUpdateCmsPageUrlRewrite
		$I->comment("Exiting Action Group [updateCmsPageUrlRewrite] AdminUpdateUrlRewriteActionGroup");
		$I->comment("Assert Cms Page Url Rewrite in grid");
		$I->comment("Entering Action Group [searchByNewRequestPath] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchByNewRequestPath
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchByNewRequestPath
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByNewRequestPath
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByNewRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchByNewRequestPath
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchByNewRequestPath
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchByNewRequestPathWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "CMSpage" . msq("defaultCmsPage")); // stepKey: fillRedirectPathFilterSearchByNewRequestPath
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchByNewRequestPath
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchByNewRequestPathWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchByNewRequestPath
		$I->see("CMSpage" . msq("defaultCmsPage"), "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchByNewRequestPath
		$I->see("cms/page/view/page_id/{$cmsId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchByNewRequestPath
		$I->see("No", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchByNewRequestPath
		$I->comment("Exiting Action Group [searchByNewRequestPath] AdminSearchByRequestPathActionGroup");
		$I->comment("Assert Updated Request Path directs to the CMS Page on Store Front");
		$I->comment("Entering Action Group [navigateToTheStoreFront] NavigateToStorefrontForCreatedPageActionGroup");
		$I->amOnPage("CMSpage" . msq("defaultCmsPage")); // stepKey: goToStorefrontNavigateToTheStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToTheStoreFront
		$I->comment("Exiting Action Group [navigateToTheStoreFront] NavigateToStorefrontForCreatedPageActionGroup");
		$I->comment("Assert updated CMS redirect in Store Front");
		$I->comment("Entering Action Group [assertCMSPage] AssertStoreFrontCMSPageActionGroup");
		$I->see($I->retrieveEntityField('createCMSPage', 'title', 'test'), "//div[@class='breadcrumbs']//ul/li[@class='item cms_page']"); // stepKey: seeTitleAssertCMSPage
		$I->see($I->retrieveEntityField('createCMSPage', 'content_heading', 'test'), "#maincontent .page-title"); // stepKey: seeContentHeadingAssertCMSPage
		$I->see($I->retrieveEntityField('createCMSPage', 'content', 'test'), "#maincontent"); // stepKey: seeContentAssertCMSPage
		$I->comment("Exiting Action Group [assertCMSPage] AssertStoreFrontCMSPageActionGroup");
	}
}
