<?php
namespace Magento\AcceptanceTest\_WYSIWYGDisabledSuite\Backend;

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
 * @Title("MC-14675: Create CMS Page via the Admin")
 * @Description("Admin should be able to create a CMS Page<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCMSPageCreatePageTest.xml<br>")
 * @TestCaseId("MC-14675")
 * @group backend
 * @group Cms
 * @group mtf_migrated
 * @group WYSIWYGDisabled
 */
class AdminCMSPageCreatePageTestCest
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
	 * @Features({"Cms"})
	 * @Stories({"Create a CMS Page via the Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCMSPageCreatePageTest(AcceptanceTester $I)
	{
		$I->comment("Go to New CMS Page page");
		$I->comment("Entering Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: navigateToCreateNewPageNavigateToCreateNewPage
		$I->waitForPageLoad(30); // stepKey: waitForNewPagePageLoadNavigateToCreateNewPage
		$I->comment("Exiting Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->comment("Entering Action Group [fillBasicPageData] FillOutCMSPageContent");
		$I->fillField("input[name=title]", "testpage"); // stepKey: fillFieldTitleFillBasicPageData
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageFillBasicPageData
		$I->fillField("input[name=content_heading]", "Test Content Heading"); // stepKey: fillFieldContentHeadingFillBasicPageData
		$I->scrollTo("#cms_page_form_content"); // stepKey: scrollToPageContentFillBasicPageData
		$I->fillField("#cms_page_form_content", "Sample page content. Yada yada yada."); // stepKey: fillFieldContentFillBasicPageData
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationFillBasicPageData
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationFillBasicPageDataWaitForPageLoad
		$I->fillField("input[name=identifier]", "testpage-" . msq("_duplicatedCMSPage")); // stepKey: fillFieldUrlKeyFillBasicPageData
		$I->comment("Exiting Action Group [fillBasicPageData] FillOutCMSPageContent");
		$I->comment("verify successfully saved");
		$I->comment("Entering Action Group [saveNewPage] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonSaveNewPage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonSaveNewPageWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonSaveNewPage
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonSaveNewPageWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageSaveNewPage
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageSaveNewPageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageSaveNewPage
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageSaveNewPageWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonSaveNewPage
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonSaveNewPageWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveNewPage
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageSaveNewPage
		$I->comment("Exiting Action Group [saveNewPage] SaveCmsPageActionGroup");
		$I->comment("verify page on frontend");
		$I->comment("Entering Action Group [navigateToPageOnStoreFront] StorefrontGoToCMSPageActionGroup");
		$I->amOnPage("//testpage-" . msq("_duplicatedCMSPage")); // stepKey: amOnCmsPageOnStorefrontNavigateToPageOnStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnStorefrontNavigateToPageOnStoreFront
		$I->comment("Exiting Action Group [navigateToPageOnStoreFront] StorefrontGoToCMSPageActionGroup");
		$I->comment("Entering Action Group [verifyPageDataOnFrontend] AssertStoreFrontCMSPageActionGroup");
		$I->see("testpage", "//div[@class='breadcrumbs']//ul/li[@class='item cms_page']"); // stepKey: seeTitleVerifyPageDataOnFrontend
		$I->see("Test Content Heading", "#maincontent .page-title"); // stepKey: seeContentHeadingVerifyPageDataOnFrontend
		$I->see("Sample page content. Yada yada yada.", "#maincontent"); // stepKey: seeContentVerifyPageDataOnFrontend
		$I->comment("Exiting Action Group [verifyPageDataOnFrontend] AssertStoreFrontCMSPageActionGroup");
		$I->comment("verify page in grid");
		$I->comment("Entering Action Group [openCMSPagesGridActionGroup] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridOpenCMSPagesGridActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCMSPagesGridActionGroup
		$I->comment("Exiting Action Group [openCMSPagesGridActionGroup] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Entering Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [sortGridByIdDescending] SortByIdDescendingActionGroup");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingSortGridByIdDescending
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishSortGridByIdDescending
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingSortGridByIdDescending
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishSortGridByIdDescending
		$I->comment("Exiting Action Group [sortGridByIdDescending] SortByIdDescendingActionGroup");
		$I->comment("Entering Action Group [verifyPageInGrid] AdminSelectCMSPageFromGridActionGroup");
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCMSPageVerifyPageInGrid
		$I->comment("Exiting Action Group [verifyPageInGrid] AdminSelectCMSPageFromGridActionGroup");
		$I->comment("Entering Action Group [deletePage] DeletePageByUrlKeyActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: amOnCMSNewPageDeletePage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeletePage
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectDeletePage
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickDeleteDeletePage
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForOkButtonToBeVisibleDeletePage
		$I->waitForPageLoad(60); // stepKey: waitForOkButtonToBeVisibleDeletePageWaitForPageLoad
		$I->click(".action-primary.action-accept"); // stepKey: clickOkButtonDeletePage
		$I->waitForPageLoad(60); // stepKey: clickOkButtonDeletePageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3DeletePage
		$I->see("The page has been deleted."); // stepKey: seeSuccessMessageDeletePage
		$I->comment("Exiting Action Group [deletePage] DeletePageByUrlKeyActionGroup");
	}
}
