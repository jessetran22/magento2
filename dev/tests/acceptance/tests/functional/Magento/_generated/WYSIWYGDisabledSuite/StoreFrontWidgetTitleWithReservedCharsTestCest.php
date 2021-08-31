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
 * @Title("MC-37419: Create CMS Page via the Admin when widget title contains reserved chairs")
 * @Description("See CMS Page title on store front page if titled widget with reserved chairs added<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/StoreFrontWidgetTitleWithReservedCharsTest.xml<br>")
 * @TestCaseId("MC-37419")
 * @group Cms
 * @group WYSIWYGDisabled
 */
class StoreFrontWidgetTitleWithReservedCharsTestCest
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
		$I->createEntity("createSimpleProductWithoutCategory", "hook", "simpleProductWithoutCategory", [], []); // stepKey: createSimpleProductWithoutCategory
		$I->createEntity("createCmsPage", "hook", "_defaultCmsPage", [], []); // stepKey: createCmsPage
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProductWithoutCategory", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCmsPage", "hook"); // stepKey: deleteCmsPage
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
	 * @Stories({"Create a CMS Page via the Admin when widget title contains reserved chairs"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontWidgetTitleWithReservedCharsTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to Page in Admin");
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
		$I->click("//div[text()='" . $I->retrieveEntityField('createCmsPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCreatedCMSPageNavigateToCreatedCMSPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCmsPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: navigateToCreatedCMSPageNavigateToCreatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSPage
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageNavigateToCreatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSPage
		$I->comment("Exiting Action Group [navigateToCreatedCMSPage] NavigateToCreatedCMSPageActionGroup");
		$I->comment("Insert widget");
		$I->comment("Entering Action Group [insertWidgetToCmsPageContent] AdminInsertWidgetToCmsPageContentActionGroup");
		$I->waitForElementVisible("//span[contains(text(),'Insert Widget...')]", 30); // stepKey: waitForInsertWidgetElementVisibleInsertWidgetToCmsPageContent
		$I->click("//span[contains(text(),'Insert Widget...')]"); // stepKey: clickOnInsertWidgetButtonInsertWidgetToCmsPageContent
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterClickOnInsertWidgetButtonInsertWidgetToCmsPageContent
		$I->waitForElementVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForInsertWidgetTitleInsertWidgetToCmsPageContent
		$I->selectOption("#select_widget_type", "Catalog Products List"); // stepKey: selectWidgetTypeInsertWidgetToCmsPageContent
		$I->comment("Exiting Action Group [insertWidgetToCmsPageContent] AdminInsertWidgetToCmsPageContentActionGroup");
		$I->comment("Fill widget title and save");
		$I->comment("Entering Action Group [fillWidgetTitle] AdminFillCatalogProductsListWidgetTitleActionGroup");
		$I->waitForElementVisible("input[name='parameters[title]']", 30); // stepKey: waitForFieldFillWidgetTitle
		$I->fillField("input[name='parameters[title]']", "Tittle }}"); // stepKey: fillTitleFieldFillWidgetTitle
		$I->comment("Exiting Action Group [fillWidgetTitle] AdminFillCatalogProductsListWidgetTitleActionGroup");
		$I->comment("Entering Action Group [clickInsertWidgetButton] AdminClickInsertWidgetActionGroup");
		$I->click("#insert_button"); // stepKey: clickInsertWidgetButtonClickInsertWidgetButton
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetButtonClickInsertWidgetButtonWaitForPageLoad
		$I->waitForElementNotVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForWidgetPopupDisappearClickInsertWidgetButton
		$I->comment("Exiting Action Group [clickInsertWidgetButton] AdminClickInsertWidgetActionGroup");
		$I->comment("Entering Action Group [saveOpenedPage] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonSaveOpenedPage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonSaveOpenedPageWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonSaveOpenedPage
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonSaveOpenedPageWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageSaveOpenedPage
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageSaveOpenedPageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageSaveOpenedPage
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageSaveOpenedPageWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonSaveOpenedPage
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonSaveOpenedPageWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveOpenedPage
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageSaveOpenedPage
		$I->comment("Exiting Action Group [saveOpenedPage] SaveCmsPageActionGroup");
		$I->comment("Verify data on frontend");
		$I->comment("Entering Action Group [navigateToPageOnStorefront] StorefrontGoToCMSPageActionGroup");
		$I->amOnPage("//" . $I->retrieveEntityField('createCmsPage', 'identifier', 'test')); // stepKey: amOnCmsPageOnStorefrontNavigateToPageOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnStorefrontNavigateToPageOnStorefront
		$I->comment("Exiting Action Group [navigateToPageOnStorefront] StorefrontGoToCMSPageActionGroup");
		$I->comment("Entering Action Group [verifyPageDataOnFrontend] StorefrontAssertWidgetTitleActionGroup");
		$grabWidgetTitleVerifyPageDataOnFrontend = $I->grabTextFrom(".block.widget.block-products-list.grid .block-title"); // stepKey: grabWidgetTitleVerifyPageDataOnFrontend
		$I->assertEquals("Tittle }}", "$grabWidgetTitleVerifyPageDataOnFrontend"); // stepKey: assertWidgetTitleVerifyPageDataOnFrontend
		$I->comment("Exiting Action Group [verifyPageDataOnFrontend] StorefrontAssertWidgetTitleActionGroup");
	}
}
