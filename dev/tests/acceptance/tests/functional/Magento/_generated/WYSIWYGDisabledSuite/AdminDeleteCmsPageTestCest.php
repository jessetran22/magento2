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
 * @Title("[NO TESTCASEID]: Admin should be able to delete CMS Pages")
 * @Description("Admin should be able to delete CMS Pages<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminDeleteCmsPageTest.xml<br>")
 * @group Cms
 * @group WYSIWYGDisabled
 */
class AdminDeleteCmsPageTestCest
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
		$I->comment("Entering Action Group [navigateToCmsPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCmsPageGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCmsPageGrid
		$I->comment("Exiting Action Group [navigateToCmsPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Entering Action Group [clearGridSearchFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridSearchFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridSearchFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridSearchFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [createNewPageWithBasicValues] CreateNewPageWithBasicValues");
		$I->click("#add"); // stepKey: clickAddNewPageCreateNewPageWithBasicValues
		$I->waitForPageLoad(30); // stepKey: clickAddNewPageCreateNewPageWithBasicValuesWaitForPageLoad
		$I->fillField("input[name=title]", "Test CMS Page"); // stepKey: fillFieldTitleCreateNewPageWithBasicValues
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentCreateNewPageWithBasicValues
		$I->fillField("input[name=content_heading]", "Test Content Heading"); // stepKey: fillFieldContentHeadingCreateNewPageWithBasicValues
		$I->fillField("#cms_page_form_content", "Sample page content. Yada yada yada."); // stepKey: fillFieldContentCreateNewPageWithBasicValues
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationCreateNewPageWithBasicValues
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationCreateNewPageWithBasicValuesWaitForPageLoad
		$I->fillField("input[name=identifier]", "test-page-" . msq("_defaultCmsPage")); // stepKey: fillFieldUrlKeyCreateNewPageWithBasicValues
		$I->comment("Exiting Action Group [createNewPageWithBasicValues] CreateNewPageWithBasicValues");
		$I->comment("Entering Action Group [clickSaveCmsPageButton] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonClickSaveCmsPageButton
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonClickSaveCmsPageButtonWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonClickSaveCmsPageButton
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonClickSaveCmsPageButtonWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageClickSaveCmsPageButton
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageClickSaveCmsPageButtonWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageClickSaveCmsPageButton
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageClickSaveCmsPageButtonWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonClickSaveCmsPageButton
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonClickSaveCmsPageButtonWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveCmsPageButton
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageClickSaveCmsPageButton
		$I->comment("Exiting Action Group [clickSaveCmsPageButton] SaveCmsPageActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Stories({"Delete a CMS Page via the Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteCmsPageTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [findCreatedCmsPage] AdminSearchCmsPageInGridByUrlKeyActionGroup");
		$I->click("//button[text()='Filters']"); // stepKey: clickFilterButtonFindCreatedCmsPage
		$I->fillField("//div[@class='admin__form-field-control']/input[@name='identifier']", "test-page-" . msq("_defaultCmsPage")); // stepKey: fillUrlKeyFieldFindCreatedCmsPage
		$I->click("//span[text()='Apply Filters']"); // stepKey: clickApplyFiltersButtonFindCreatedCmsPage
		$I->waitForPageLoad(60); // stepKey: clickApplyFiltersButtonFindCreatedCmsPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingFindCreatedCmsPage
		$I->comment("Exiting Action Group [findCreatedCmsPage] AdminSearchCmsPageInGridByUrlKeyActionGroup");
		$I->comment("Entering Action Group [deleteCmsPage] AdminDeleteCmsPageFromGridActionGroup");
		$I->click("//div[text()='test-page-" . msq("_defaultCmsPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectDeleteCmsPage
		$I->click("//div[text()='test-page-" . msq("_defaultCmsPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickDeleteDeleteCmsPage
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForOkButtonToBeVisibleDeleteCmsPage
		$I->waitForPageLoad(60); // stepKey: waitForOkButtonToBeVisibleDeleteCmsPageWaitForPageLoad
		$I->click(".action-primary.action-accept"); // stepKey: clickOkButtonDeleteCmsPage
		$I->waitForPageLoad(60); // stepKey: clickOkButtonDeleteCmsPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3DeleteCmsPage
		$I->comment("Exiting Action Group [deleteCmsPage] AdminDeleteCmsPageFromGridActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessage
		$I->see("The page has been deleted.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [searchDeletedPage] AdminSearchCmsPageInGridByUrlKeyActionGroup");
		$I->click("//button[text()='Filters']"); // stepKey: clickFilterButtonSearchDeletedPage
		$I->fillField("//div[@class='admin__form-field-control']/input[@name='identifier']", "test-page-" . msq("_defaultCmsPage")); // stepKey: fillUrlKeyFieldSearchDeletedPage
		$I->click("//span[text()='Apply Filters']"); // stepKey: clickApplyFiltersButtonSearchDeletedPage
		$I->waitForPageLoad(60); // stepKey: clickApplyFiltersButtonSearchDeletedPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingSearchDeletedPage
		$I->comment("Exiting Action Group [searchDeletedPage] AdminSearchCmsPageInGridByUrlKeyActionGroup");
		$I->comment("Entering Action Group [assertCmsPageIsNotInGrid] AssertAdminCmsPageIsNotInGridActionGroup");
		$I->dontSee("test-page-" . msq("_defaultCmsPage"), ".data-row .data-grid-cell-content"); // stepKey: dontSeeCmsPageInGridAssertCmsPageIsNotInGrid
		$I->comment("Exiting Action Group [assertCmsPageIsNotInGrid] AssertAdminCmsPageIsNotInGridActionGroup");
	}
}
