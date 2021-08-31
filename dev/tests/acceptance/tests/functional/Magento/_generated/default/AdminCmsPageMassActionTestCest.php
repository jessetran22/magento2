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
 * @Title("MC-14659: Create two CMS Pages and perform mass disable action")
 * @Description("Admin should be able to perform mass actions to CMS pages<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCmsPageMassActionTest.xml<br>")
 * @TestCaseId("MC-14659")
 * @group backend
 * @group CMSContent
 * @group mtf_migrated
 */
class AdminCmsPageMassActionTestCest
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
		$I->createEntity("firstCMSPage", "hook", "_defaultCmsPage", [], []); // stepKey: firstCMSPage
		$I->createEntity("secondCMSPage", "hook", "_duplicatedCMSPage", [], []); // stepKey: secondCMSPage
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("firstCMSPage", "hook"); // stepKey: deleteFirstCMSPage
		$I->deleteEntity("secondCMSPage", "hook"); // stepKey: deleteSecondCMSPage
		$I->comment("Entering Action Group [navigateToCMSPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCMSPageGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCMSPageGrid
		$I->comment("Exiting Action Group [navigateToCMSPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Entering Action Group [clearPossibleGridFilters] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearPossibleGridFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearPossibleGridFilters
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearPossibleGridFilters
		$I->comment("Exiting Action Group [clearPossibleGridFilters] AdminGridFilterResetActionGroup");
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
	 * @Stories({"Create CMS Page", "Admin Grid Mass Action"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCmsPageMassActionTest(AcceptanceTester $I)
	{
		$I->comment("Go to Grid page");
		$I->comment("Entering Action Group [navigateToCMSPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCMSPageGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCMSPageGrid
		$I->comment("Exiting Action Group [navigateToCMSPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Entering Action Group [clearPossibleGridFilters] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearPossibleGridFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearPossibleGridFilters
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearPossibleGridFilters
		$I->comment("Exiting Action Group [clearPossibleGridFilters] AdminGridFilterResetActionGroup");
		$I->comment("Select pages in Grid");
		$I->comment("Entering Action Group [selectFirstCMSPage] AdminSelectCMSPageInGridActionGroup");
		$I->checkOption("//table[@data-role='grid']//td[count(../../..//th[./*[.='URL Key']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('firstCMSPage', 'identifier', 'test') . "']]/../td//input[@data-action='select-row']"); // stepKey: selectCmsPageInGridSelectFirstCMSPage
		$I->comment("Exiting Action Group [selectFirstCMSPage] AdminSelectCMSPageInGridActionGroup");
		$I->comment("Entering Action Group [selectSecondCMSPage] AdminSelectCMSPageInGridActionGroup");
		$I->checkOption("//table[@data-role='grid']//td[count(../../..//th[./*[.='URL Key']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('secondCMSPage', 'identifier', 'test') . "']]/../td//input[@data-action='select-row']"); // stepKey: selectCmsPageInGridSelectSecondCMSPage
		$I->comment("Exiting Action Group [selectSecondCMSPage] AdminSelectCMSPageInGridActionGroup");
		$I->comment("Disable Pages");
		$I->comment("Entering Action Group [disablePages] AdminCMSPageMassActionSelectActionGroup");
		$I->click("//div[@class='admin__data-grid-header'][(not(ancestor::*[@class='sticky-header']) and not(contains(@style,'visibility: hidden'))) or (ancestor::*[@class='sticky-header' and not(contains(@style,'display: none'))])]//button[contains(@class, 'action-select')]"); // stepKey: clickMassActionDropdownDisablePages
		$I->click("//div[@class='admin__data-grid-header'][(not(ancestor::*[@class='sticky-header']) and not(contains(@style,'visibility: hidden'))) or (ancestor::*[@class='sticky-header' and not(contains(@style,'display: none'))])]//span[contains(@class, 'action-menu-item') and .= 'Disable']"); // stepKey: clickActionDisablePages
		$I->waitForPageLoad(30); // stepKey: waitForPageToReloadDisablePages
		$I->comment("Exiting Action Group [disablePages] AdminCMSPageMassActionSelectActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessage
		$I->see("A total of 2 record(s) have been disabled.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Verify pages in Grid");
		$I->comment("Entering Action Group [clearGridFilters] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearGridFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearGridFilters
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearGridFilters
		$I->comment("Exiting Action Group [clearGridFilters] AdminGridFilterResetActionGroup");
		$I->comment("Entering Action Group [filterGridByFirstCmsPageIdentifier] AdminGridFilterFillInputFieldActionGroup");
		$I->conditionalClick("//div[@class='admin__data-grid-header'][(not(ancestor::*[@class='sticky-header']) and not(contains(@style,'visibility: hidden'))) or (ancestor::*[@class='sticky-header' and not(contains(@style,'display: none'))])]//button[@data-action='grid-filter-expand']", "[data-part='filter-form']", false); // stepKey: openFiltersFormIfNecessaryFilterGridByFirstCmsPageIdentifier
		$I->waitForElementVisible("[data-part='filter-form']", 30); // stepKey: waitForFormVisibleFilterGridByFirstCmsPageIdentifier
		$I->fillField("//*[@data-part='filter-form']//input[@name='identifier']", $I->retrieveEntityField('firstCMSPage', 'identifier', 'test')); // stepKey: fillFilterInputFieldFilterGridByFirstCmsPageIdentifier
		$I->comment("Exiting Action Group [filterGridByFirstCmsPageIdentifier] AdminGridFilterFillInputFieldActionGroup");
		$I->comment("Entering Action Group [applyFirstGridFilters] AdminGridFilterApplyActionGroup");
		$I->click("//*[@data-part='filter-form']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplyFirstGridFilters
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetApplyFirstGridFilters
		$I->comment("Exiting Action Group [applyFirstGridFilters] AdminGridFilterApplyActionGroup");
		$I->comment("Entering Action Group [assertFirstCmsPageInGrid] AssertCMSPageInGridActionGroup");
		$I->seeElement("//tbody/tr[td[*[text()[normalize-space()='" . $I->retrieveEntityField('firstCMSPage', 'identifier', 'test') . "']]]]"); // stepKey: seeElementByCmsPageIdentifierAssertFirstCmsPageInGrid
		$I->see($I->retrieveEntityField('firstCMSPage', 'title', 'test'), "//tbody/tr[td[*[text()[normalize-space()='" . $I->retrieveEntityField('firstCMSPage', 'identifier', 'test') . "']]]]"); // stepKey: seeCmsPageTitleAssertFirstCmsPageInGrid
		$I->comment("Exiting Action Group [assertFirstCmsPageInGrid] AssertCMSPageInGridActionGroup");
		$I->comment("Entering Action Group [filterGridBySecondCmsPageIdentifier] AdminGridFilterFillInputFieldActionGroup");
		$I->conditionalClick("//div[@class='admin__data-grid-header'][(not(ancestor::*[@class='sticky-header']) and not(contains(@style,'visibility: hidden'))) or (ancestor::*[@class='sticky-header' and not(contains(@style,'display: none'))])]//button[@data-action='grid-filter-expand']", "[data-part='filter-form']", false); // stepKey: openFiltersFormIfNecessaryFilterGridBySecondCmsPageIdentifier
		$I->waitForElementVisible("[data-part='filter-form']", 30); // stepKey: waitForFormVisibleFilterGridBySecondCmsPageIdentifier
		$I->fillField("//*[@data-part='filter-form']//input[@name='identifier']", $I->retrieveEntityField('secondCMSPage', 'identifier', 'test')); // stepKey: fillFilterInputFieldFilterGridBySecondCmsPageIdentifier
		$I->comment("Exiting Action Group [filterGridBySecondCmsPageIdentifier] AdminGridFilterFillInputFieldActionGroup");
		$I->comment("Entering Action Group [applySecondGridFilters] AdminGridFilterApplyActionGroup");
		$I->click("//*[@data-part='filter-form']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplySecondGridFilters
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetApplySecondGridFilters
		$I->comment("Exiting Action Group [applySecondGridFilters] AdminGridFilterApplyActionGroup");
		$I->comment("Entering Action Group [assertSecondCmsPageInGrid] AssertCMSPageInGridActionGroup");
		$I->seeElement("//tbody/tr[td[*[text()[normalize-space()='" . $I->retrieveEntityField('secondCMSPage', 'identifier', 'test') . "']]]]"); // stepKey: seeElementByCmsPageIdentifierAssertSecondCmsPageInGrid
		$I->see($I->retrieveEntityField('secondCMSPage', 'title', 'test'), "//tbody/tr[td[*[text()[normalize-space()='" . $I->retrieveEntityField('secondCMSPage', 'identifier', 'test') . "']]]]"); // stepKey: seeCmsPageTitleAssertSecondCmsPageInGrid
		$I->comment("Exiting Action Group [assertSecondCmsPageInGrid] AssertCMSPageInGridActionGroup");
		$I->comment("Entering Action Group [clearGridFiltersToIsolateTest] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearGridFiltersToIsolateTest
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearGridFiltersToIsolateTest
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearGridFiltersToIsolateTest
		$I->comment("Exiting Action Group [clearGridFiltersToIsolateTest] AdminGridFilterResetActionGroup");
		$I->comment("Verify pages are disabled on Storefront");
		$I->comment("Entering Action Group [goToFirstCMSPageOnStorefront] StorefrontGoToCMSPageActionGroup");
		$I->amOnPage("//" . $I->retrieveEntityField('firstCMSPage', 'identifier', 'test')); // stepKey: amOnCmsPageOnStorefrontGoToFirstCMSPageOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnStorefrontGoToFirstCMSPageOnStorefront
		$I->comment("Exiting Action Group [goToFirstCMSPageOnStorefront] StorefrontGoToCMSPageActionGroup");
		$I->comment("Entering Action Group [seeNotFoundErrorForFirstPage] AssertCMSPageNotFoundOnStorefrontActionGroup");
		$I->see("Whoops, our bad..."); // stepKey: seePageErrorNotFoundSeeNotFoundErrorForFirstPage
		$I->comment("Exiting Action Group [seeNotFoundErrorForFirstPage] AssertCMSPageNotFoundOnStorefrontActionGroup");
		$I->comment("Entering Action Group [goToSecondCMSPageOnStorefront] StorefrontGoToCMSPageActionGroup");
		$I->amOnPage("//" . $I->retrieveEntityField('secondCMSPage', 'identifier', 'test')); // stepKey: amOnCmsPageOnStorefrontGoToSecondCMSPageOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnStorefrontGoToSecondCMSPageOnStorefront
		$I->comment("Exiting Action Group [goToSecondCMSPageOnStorefront] StorefrontGoToCMSPageActionGroup");
		$I->comment("Entering Action Group [seeNotFoundErrorForSecondPage] AssertCMSPageNotFoundOnStorefrontActionGroup");
		$I->see("Whoops, our bad..."); // stepKey: seePageErrorNotFoundSeeNotFoundErrorForSecondPage
		$I->comment("Exiting Action Group [seeNotFoundErrorForSecondPage] AssertCMSPageNotFoundOnStorefrontActionGroup");
	}
}
