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
 * @Title(": Delete CMS Page No Redirect URL rewrite")
 * @Description("Login as Admin and remove CMS Page Url Rewrite<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminDeleteCMSPageNoRedirectUrlRewriteTest.xml<br>")
 * @TestCaseId("")
 * @group mtf_migrated
 */
class AdminDeleteCMSPageNoRedirectUrlRewriteTestCest
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
	 * @Stories({"Delete CMS Page No Redirect URL rewrite"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"UrlRewrite"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteCMSPageNoRedirectUrlRewriteTest(AcceptanceTester $I)
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
		$I->comment("Assert initial CMS page Url Rewrite in Grid");
		$I->comment("Entering Action Group [searchByRequestPath1] AdminSearchByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchByRequestPath1
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchByRequestPath1
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByRequestPath1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByRequestPath1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchByRequestPath1
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchByRequestPath1
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchByRequestPath1WaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createCMSPage', 'identifier', 'test')); // stepKey: fillRedirectPathFilterSearchByRequestPath1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchByRequestPath1
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchByRequestPath1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchByRequestPath1
		$I->see($I->retrieveEntityField('createCMSPage', 'identifier', 'test'), "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrlSearchByRequestPath1
		$I->see("cms/page/view/page_id/{$cmsId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathSearchByRequestPath1
		$I->see("No", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrlSearchByRequestPath1
		$I->comment("Exiting Action Group [searchByRequestPath1] AdminSearchByRequestPathActionGroup");
		$I->comment("Assert initial request path directs to the CMS Page on Store Front");
		$I->comment("Entering Action Group [navigateToTheStoreFront1] NavigateToStorefrontForCreatedPageActionGroup");
		$I->amOnPage($I->retrieveEntityField('createCMSPage', 'identifier', 'test')); // stepKey: goToStorefrontNavigateToTheStoreFront1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToTheStoreFront1
		$I->comment("Exiting Action Group [navigateToTheStoreFront1] NavigateToStorefrontForCreatedPageActionGroup");
		$I->comment("Delete created cms page url rewrite and verify AssertUrlRewriteDeletedMessage");
		$I->comment("Entering Action Group [deleteUrlRewrite] AdminDeleteUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageDeleteUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadDeleteUrlRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersDeleteUrlRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersDeleteUrlRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createCMSPage', 'identifier', 'test')); // stepKey: fillRedirectPathFilterDeleteUrlRewrite
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersDeleteUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersDeleteUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1DeleteUrlRewrite
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//button[contains(@class, 'action-select')]"); // stepKey: clickOnRowSelectButtonDeleteUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnRowSelectButtonDeleteUrlRewriteWaitForPageLoad
		$I->click("//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Action')]/preceding-sibling::th)+1]//a[contains(., 'Edit')]"); // stepKey: clickOnEditButtonDeleteUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnEditButtonDeleteUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForEditPageToLoadDeleteUrlRewrite
		$I->click("#delete"); // stepKey: clickOnDeleteButtonDeleteUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteButtonDeleteUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad2DeleteUrlRewrite
		$I->waitForElementVisible("//button[@class='action-primary action-accept']", 30); // stepKey: waitForOkButtonToVisibleDeleteUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForOkButtonToVisibleDeleteUrlRewriteWaitForPageLoad
		$I->click("//button[@class='action-primary action-accept']"); // stepKey: clickOnOkButtonDeleteUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOnOkButtonDeleteUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad3DeleteUrlRewrite
		$I->see("You deleted the URL rewrite.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteUrlRewrite
		$I->comment("Exiting Action Group [deleteUrlRewrite] AdminDeleteUrlRewriteActionGroup");
		$I->comment("Search and verify AssertUrlRewriteNotInGrid");
		$I->comment("Entering Action Group [searchDeletedUrlRewriteInGrid] AdminSearchDeletedUrlRewriteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchDeletedUrlRewriteInGrid
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchDeletedUrlRewriteInGrid
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchDeletedUrlRewriteInGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchDeletedUrlRewriteInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchDeletedUrlRewriteInGrid
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchDeletedUrlRewriteInGrid
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchDeletedUrlRewriteInGridWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createCMSPage', 'identifier', 'test')); // stepKey: fillRedirectPathFilterSearchDeletedUrlRewriteInGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchDeletedUrlRewriteInGrid
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchDeletedUrlRewriteInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchDeletedUrlRewriteInGrid
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: seeEmptyRecordMessageSearchDeletedUrlRewriteInGrid
		$I->comment("Exiting Action Group [searchDeletedUrlRewriteInGrid] AdminSearchDeletedUrlRewriteActionGroup");
	}
}
