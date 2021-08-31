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
 * @Title("MC-40900: Inline changing CMS page custom theme will be applied with proper dates")
 * @Description("Verify that Merchant can inline edit CMS pages in grid and dates will be proper<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCMSPageInlineEditTest.xml<br>")
 * @TestCaseId("MC-40900")
 * @group cms
 * @group ui
 */
class AdminCMSPageInlineEditTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCmsPageGridAgain] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCmsPageGridAgain
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCmsPageGridAgain
		$I->comment("Exiting Action Group [navigateToCmsPageGridAgain] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Entering Action Group [resetGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [resetGridFilters] ClearFiltersAdminDataGridActionGroup");
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
	 * @Stories({"Inline Edit Cms Page"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCMSPageInlineEditTest(AcceptanceTester $I)
	{
		$date = new \DateTime();
		$date->setTimestamp(strtotime("now"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$today = $date->format("m/d/Y");

		$date = new \DateTime();
		$date->setTimestamp(strtotime("+1 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$tomorrow = $date->format("m/d/Y");

		$date = new \DateTime();
		$date->setTimestamp(strtotime("now"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$todayFormatted = $date->format("M j, Y");

		$date = new \DateTime();
		$date->setTimestamp(strtotime("+1 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$tomorrowFormatted = $date->format("M j, Y");

		$date = new \DateTime();
		$date->setTimestamp(strtotime("+100 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$newDateFrom = $date->format("m/d/Y");

		$date = new \DateTime();
		$date->setTimestamp(strtotime("+101 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$newDateTo = $date->format("m/d/Y");

		$date = new \DateTime();
		$date->setTimestamp(strtotime("+100 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$newDateFromFormatted = $date->format("M j, Y");

		$date = new \DateTime();
		$date->setTimestamp(strtotime("+101 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$newDateToFormatted = $date->format("M j, Y");

		$I->comment("Entering Action Group [navigateToCmsPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCmsPageGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCmsPageGrid
		$I->comment("Exiting Action Group [navigateToCmsPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Entering Action Group [showCustomerEmailColumn] AdminGridColumnShowActionGroup");
		$I->click("div.admin__data-grid-action-columns button[data-bind='toggleCollapsible']"); // stepKey: openColumnsTabShowCustomerEmailColumn
		$I->waitForPageLoad(30); // stepKey: openColumnsTabShowCustomerEmailColumnWaitForPageLoad
		$I->checkOption("//div[contains(@class,'admin__data-grid-action-columns')]//div[contains(@class, 'admin__field-option')]//label[text() = 'Custom design from']/preceding-sibling::input"); // stepKey: showNewColumnShowCustomerEmailColumn
		$I->click("div.admin__data-grid-action-columns button[data-bind='toggleCollapsible']"); // stepKey: closeColumnsTabShowCustomerEmailColumn
		$I->waitForPageLoad(30); // stepKey: closeColumnsTabShowCustomerEmailColumnWaitForPageLoad
		$I->seeElement("//div[@data-role='grid-wrapper']//table[contains(@class, 'data-grid')]/thead/tr/th[contains(@class, 'data-grid-th')]/span[text() = 'Custom design from']"); // stepKey: seeNewColumnInGridShowCustomerEmailColumn
		$I->waitForPageLoad(30); // stepKey: seeNewColumnInGridShowCustomerEmailColumnWaitForPageLoad
		$I->comment("Exiting Action Group [showCustomerEmailColumn] AdminGridColumnShowActionGroup");
		$I->comment("Entering Action Group [showCustomerEmailColumnTwo] AdminGridColumnShowActionGroup");
		$I->click("div.admin__data-grid-action-columns button[data-bind='toggleCollapsible']"); // stepKey: openColumnsTabShowCustomerEmailColumnTwo
		$I->waitForPageLoad(30); // stepKey: openColumnsTabShowCustomerEmailColumnTwoWaitForPageLoad
		$I->checkOption("//div[contains(@class,'admin__data-grid-action-columns')]//div[contains(@class, 'admin__field-option')]//label[text() = 'Custom design to']/preceding-sibling::input"); // stepKey: showNewColumnShowCustomerEmailColumnTwo
		$I->click("div.admin__data-grid-action-columns button[data-bind='toggleCollapsible']"); // stepKey: closeColumnsTabShowCustomerEmailColumnTwo
		$I->waitForPageLoad(30); // stepKey: closeColumnsTabShowCustomerEmailColumnTwoWaitForPageLoad
		$I->seeElement("//div[@data-role='grid-wrapper']//table[contains(@class, 'data-grid')]/thead/tr/th[contains(@class, 'data-grid-th')]/span[text() = 'Custom design to']"); // stepKey: seeNewColumnInGridShowCustomerEmailColumnTwo
		$I->waitForPageLoad(30); // stepKey: seeNewColumnInGridShowCustomerEmailColumnTwoWaitForPageLoad
		$I->comment("Exiting Action Group [showCustomerEmailColumnTwo] AdminGridColumnShowActionGroup");
		$I->comment("Entering Action Group [clickClearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClickClearFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClickClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clickClearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", "404 Not Found"); // stepKey: fillKeywordSearchFieldWithSecondCustomerEmail
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearch
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchWaitForPageLoad
		$I->see("404 Not Found", "tr[data-repeat-index='0']"); // stepKey: seeFirstCmsPageAfterFiltering
		$I->click(".data-grid .action-select-wrap button.action-select"); // stepKey: clickOnSelectButton
		$I->waitForPageLoad(30); // stepKey: clickOnSelectButtonWaitForPageLoad
		$I->click(".data-grid .action-select-wrap .action-menu-item[data-action~='item-edit']"); // stepKey: clickOnEditButton
		$I->waitForPageLoad(30); // stepKey: clickOnEditButtonWaitForPageLoad
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Custom Design Update']"); // stepKey: clickOnDesignTab
		$I->waitForElementVisible("input[name='custom_theme_from']", 30); // stepKey: waitForLayoutDropDown
		$I->fillField("input[name='custom_theme_from']", $today); // stepKey: fillDateFrom
		$I->fillField("input[name='custom_theme_to']", $tomorrow); // stepKey: fillDateTo
		$I->selectOption("//div[@data-index='custom_design_update']//select[@name='custom_theme']", "Magento Blank"); // stepKey: fillCustomTheme
		$I->comment("Entering Action Group [saveCmsPage] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonSaveCmsPageWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonSaveCmsPageWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageSaveCmsPageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageSaveCmsPageWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonSaveCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonSaveCmsPageWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveCmsPage
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageSaveCmsPage
		$I->comment("Exiting Action Group [saveCmsPage] SaveCmsPageActionGroup");
		$I->see($todayFormatted, "//tr[2]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Custom design from')]/preceding-sibling::th) +1 ]"); // stepKey: assertCustomDesignFrom
		$I->see($tomorrowFormatted, "//tr[2]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Custom design to')]/preceding-sibling::th) +1 ]"); // stepKey: assertCustomDesignTo
		$I->click("table.data-grid tbody > tr.data-row"); // stepKey: clickEdit
		$I->waitForElementVisible("tr.data-grid-editable-row:not([style*='display: none']) [name='page_layout']", 30); // stepKey: waitForDate
		$I->selectOption("tr.data-grid-editable-row:not([style*='display: none']) [name='page_layout']", "2 columns with right bar"); // stepKey: changeLayoutFromGrid
		$I->click("tr.data-grid-editable-row-actions button.action-primary"); // stepKey: clickSaveFromGrid
		$I->waitForPageLoad(30); // stepKey: clickSaveFromGridWaitForPageLoad
		$I->see($todayFormatted, "//tr[2]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Custom design from')]/preceding-sibling::th) +1 ]"); // stepKey: assertCustomDesignFrom2
		$I->see($tomorrowFormatted, "//tr[2]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Custom design to')]/preceding-sibling::th) +1 ]"); // stepKey: assertCustomDesignTo2
		$I->click("table.data-grid tbody > tr.data-row"); // stepKey: clickEdit2
		$I->waitForElementVisible("tr.data-grid-editable-row:not([style*='display: none']) [name='page_layout']", 30); // stepKey: waitForDate2
		$I->selectOption("tr.data-grid-editable-row:not([style*='display: none']) [name='page_layout']", "2 columns with left bar"); // stepKey: changeLayoutFromGrid2
		$I->click("tr.data-grid-editable-row-actions button.action-primary"); // stepKey: clickSaveFromGrid2
		$I->waitForPageLoad(30); // stepKey: clickSaveFromGrid2WaitForPageLoad
		$I->see($todayFormatted, "//tr[2]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Custom design from')]/preceding-sibling::th) +1 ]"); // stepKey: assertCustomDesignFrom3
		$I->see($tomorrowFormatted, "//tr[2]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Custom design to')]/preceding-sibling::th) +1 ]"); // stepKey: assertCustomDesignTo3
		$I->click("table.data-grid tbody > tr.data-row"); // stepKey: clickEdit3
		$I->waitForElementVisible("tr.data-grid-editable-row:not([style*='display: none']) [name='custom_theme_from']", 30); // stepKey: waitForDate3
		$I->fillField("tr.data-grid-editable-row:not([style*='display: none']) [name='custom_theme_from']", $newDateFrom); // stepKey: fillDateFromInGrid
		$I->fillField("tr.data-grid-editable-row:not([style*='display: none']) [name='custom_theme_to']", $newDateTo); // stepKey: fillDateToInGrid
		$I->click("tr.data-grid-editable-row-actions button.action-primary"); // stepKey: clickSaveFromGrid3
		$I->waitForPageLoad(30); // stepKey: clickSaveFromGrid3WaitForPageLoad
		$I->see($newDateFromFormatted, "//tr[2]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Custom design from')]/preceding-sibling::th) +1 ]"); // stepKey: assertCustomDesignFrom4
		$I->see($newDateToFormatted, "//tr[2]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Custom design to')]/preceding-sibling::th) +1 ]"); // stepKey: assertCustomDesignTo4
	}
}
