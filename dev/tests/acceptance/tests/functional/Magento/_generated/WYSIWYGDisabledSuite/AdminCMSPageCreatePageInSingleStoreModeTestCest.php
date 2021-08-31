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
 * @Title("MC-14679: Create CMS Page via the Admin in single store mode")
 * @Description("Admin should be able to create a CMS Page<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCMSPageCreatePageInSingleStoreModeTest.xml<br>")
 * @TestCaseId("MC-14679")
 * @group backend
 * @group Cms
 * @group mtf_migrated
 * @group WYSIWYGDisabled
 */
class AdminCMSPageCreatePageInSingleStoreModeTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$enableSingleStoreMode = $I->magentoCLI("config:set general/single_store_mode/enabled 1", 60); // stepKey: enableSingleStoreMode
		$I->comment($enableSingleStoreMode);
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
		$disableSingleStoreMode = $I->magentoCLI("config:set general/single_store_mode/enabled 0", 60); // stepKey: disableSingleStoreMode
		$I->comment($disableSingleStoreMode);
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
	public function AdminCMSPageCreatePageInSingleStoreModeTest(AcceptanceTester $I)
	{
		$I->comment("Go to New CMS Page page");
		$I->comment("Entering Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: navigateToCreateNewPageNavigateToCreateNewPage
		$I->waitForPageLoad(30); // stepKey: waitForNewPagePageLoadNavigateToCreateNewPage
		$I->comment("Exiting Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->comment("Fill the CMS page form");
		$I->comment("Entering Action Group [fillBasicPageDataForPageWithDefaultStore] FillOutCMSPageContent");
		$I->fillField("input[name=title]", "testpage"); // stepKey: fillFieldTitleFillBasicPageDataForPageWithDefaultStore
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageFillBasicPageDataForPageWithDefaultStore
		$I->fillField("input[name=content_heading]", "Test Content Heading"); // stepKey: fillFieldContentHeadingFillBasicPageDataForPageWithDefaultStore
		$I->scrollTo("#cms_page_form_content"); // stepKey: scrollToPageContentFillBasicPageDataForPageWithDefaultStore
		$I->fillField("#cms_page_form_content", "Sample page content. Yada yada yada."); // stepKey: fillFieldContentFillBasicPageDataForPageWithDefaultStore
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationFillBasicPageDataForPageWithDefaultStore
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationFillBasicPageDataForPageWithDefaultStoreWaitForPageLoad
		$I->fillField("input[name=identifier]", "testpage-" . msq("_duplicatedCMSPage")); // stepKey: fillFieldUrlKeyFillBasicPageDataForPageWithDefaultStore
		$I->comment("Exiting Action Group [fillBasicPageDataForPageWithDefaultStore] FillOutCMSPageContent");
		$I->comment("Verify successfully saved");
		$I->comment("Entering Action Group [savePageInSingleStoreMode] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonSavePageInSingleStoreMode
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonSavePageInSingleStoreModeWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonSavePageInSingleStoreMode
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonSavePageInSingleStoreModeWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageSavePageInSingleStoreMode
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageSavePageInSingleStoreModeWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageSavePageInSingleStoreMode
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageSavePageInSingleStoreModeWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonSavePageInSingleStoreMode
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonSavePageInSingleStoreModeWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSavePageInSingleStoreMode
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageSavePageInSingleStoreMode
		$I->comment("Exiting Action Group [savePageInSingleStoreMode] SaveCmsPageActionGroup");
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
		$I->comment("Navigate to page in Admin");
		$I->comment("Entering Action Group [navigateToCMSPageInAdminInSingleStoreMode] NavigateToCreatedCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCMSPageInAdminInSingleStoreMode
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCMSPageInAdminInSingleStoreMode
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCMSPageInAdminInSingleStoreMode
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCMSPageInAdminInSingleStoreMode
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCMSPageInAdminInSingleStoreMode
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCMSPageInAdminInSingleStoreMode
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCMSPageInAdminInSingleStoreMode
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCMSPageInAdminInSingleStoreMode
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCreatedCMSPageNavigateToCMSPageInAdminInSingleStoreMode
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: navigateToCreatedCMSPageNavigateToCMSPageInAdminInSingleStoreMode
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCMSPageInAdminInSingleStoreMode
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageNavigateToCMSPageInAdminInSingleStoreMode
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCMSPageInAdminInSingleStoreMode
		$I->comment("Exiting Action Group [navigateToCMSPageInAdminInSingleStoreMode] NavigateToCreatedCMSPageActionGroup");
		$I->comment("Verify Page Data in Admin");
		$I->comment("Entering Action Group [verifyPageDataInAdminInSingleStoreMode] AssertCMSPageContentActionGroup");
		$grabTextFromTitleVerifyPageDataInAdminInSingleStoreMode = $I->grabValueFrom("input[name=title]"); // stepKey: grabTextFromTitleVerifyPageDataInAdminInSingleStoreMode
		$I->assertEquals("testpage", $grabTextFromTitleVerifyPageDataInAdminInSingleStoreMode, "pass"); // stepKey: assertTitleVerifyPageDataInAdminInSingleStoreMode
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageVerifyPageDataInAdminInSingleStoreMode
		$grabTextFromContentVerifyPageDataInAdminInSingleStoreMode = $I->grabValueFrom("#cms_page_form_content"); // stepKey: grabTextFromContentVerifyPageDataInAdminInSingleStoreMode
		$I->assertEquals("Sample page content. Yada yada yada.", $grabTextFromContentVerifyPageDataInAdminInSingleStoreMode, "pass"); // stepKey: assertContentVerifyPageDataInAdminInSingleStoreMode
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisationVerifyPageDataInAdminInSingleStoreMode
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationVerifyPageDataInAdminInSingleStoreModeWaitForPageLoad
		$setAttributeVerifyPageDataInAdminInSingleStoreMode = $I->executeJS("(el = document.querySelector('[name=\'identifier\']')) && el['se' + 'tAt' + 'tribute']('data-value', el.value.split('-')[0]);"); // stepKey: setAttributeVerifyPageDataInAdminInSingleStoreMode
		$I->seeElement("//input[contains(@data-value,'testpage')]"); // stepKey: seeVerifyPageDataInAdminInSingleStoreMode
		$I->comment("Exiting Action Group [verifyPageDataInAdminInSingleStoreMode] AssertCMSPageContentActionGroup");
		$I->comment("Delete page");
		$I->comment("Entering Action Group [deletePageInSingleStoreMode] DeletePageByUrlKeyActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: amOnCMSNewPageDeletePageInSingleStoreMode
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeletePageInSingleStoreMode
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectDeletePageInSingleStoreMode
		$I->click("//div[text()='testpage-" . msq("_duplicatedCMSPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickDeleteDeletePageInSingleStoreMode
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForOkButtonToBeVisibleDeletePageInSingleStoreMode
		$I->waitForPageLoad(60); // stepKey: waitForOkButtonToBeVisibleDeletePageInSingleStoreModeWaitForPageLoad
		$I->click(".action-primary.action-accept"); // stepKey: clickOkButtonDeletePageInSingleStoreMode
		$I->waitForPageLoad(60); // stepKey: clickOkButtonDeletePageInSingleStoreModeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3DeletePageInSingleStoreMode
		$I->see("The page has been deleted."); // stepKey: seeSuccessMessageDeletePageInSingleStoreMode
		$I->comment("Exiting Action Group [deletePageInSingleStoreMode] DeletePageByUrlKeyActionGroup");
	}
}
