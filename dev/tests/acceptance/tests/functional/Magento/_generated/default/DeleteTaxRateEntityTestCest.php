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
 * @Title("MC-5801: Delete tax rate")
 * @Description("Test log in to Tax Rate and Delete Tax Rate<h3>Test files</h3>app/code/Magento/Tax/Test/Mftf/Test/DeleteTaxRateEntityTest.xml<br>")
 * @TestCaseId("MC-5801")
 * @group tax
 * @group mtf_migrated
 */
class DeleteTaxRateEntityTestCest
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
		$I->createEntity("initialTaxRate", "hook", "defaultTaxRate", [], []); // stepKey: initialTaxRate
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
	 * @Stories({"Delete Tax Rate"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Tax"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function DeleteTaxRateEntityTest(AcceptanceTester $I)
	{
		$I->comment("Search the tax rate on tax grid page");
		$I->comment("Entering Action Group [goToTaxRateIndex1] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRateIndex1
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRateIndex1
		$I->comment("Exiting Action Group [goToTaxRateIndex1] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Entering Action Group [clickClearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClickClearFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClickClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clickClearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [filterByCode] AdminFilterTaxRateByCodeActionGroup");
		$I->fillField("#tax_rate_grid_filter_code", $I->retrieveEntityField('initialTaxRate', 'code', 'test')); // stepKey: fillNameFilterFilterByCode
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchFilterByCode
		$I->waitForPageLoad(30); // stepKey: clickSearchFilterByCodeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTaxRuleSearchFilterByCode
		$I->comment("Exiting Action Group [filterByCode] AdminFilterTaxRateByCodeActionGroup");
		$I->comment("Entering Action Group [clickFirstRow] AdminSelectFirstGridRowActionGroup");
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: clickFirstRowInGridClickFirstRow
		$I->waitForPageLoad(60); // stepKey: clickFirstRowInGridClickFirstRowWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitToProcessPageToLoadClickFirstRow
		$I->comment("Exiting Action Group [clickFirstRow] AdminSelectFirstGridRowActionGroup");
		$I->comment("Entering Action Group [deleteTaxRate] AdminDeleteTaxRateActionGroup");
		$I->click("#delete"); // stepKey: clickDeleteRateDeleteTaxRate
		$I->waitForPageLoad(30); // stepKey: clickDeleteRateDeleteTaxRateWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkDeleteTaxRate
		$I->waitForPageLoad(60); // stepKey: clickOkDeleteTaxRateWaitForPageLoad
		$I->comment("Exiting Action Group [deleteTaxRate] AdminDeleteTaxRateActionGroup");
		$I->see("You Deleted the tax rate.", "#messages div.message-success"); // stepKey: seeSuccess1
		$I->comment("Confirm Deleted TaxIdentifier(from the above step) on the tax rate grid page");
		$I->comment("Entering Action Group [goToTaxRateIndex2] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRateIndex2
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRateIndex2
		$I->comment("Exiting Action Group [goToTaxRateIndex2] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Entering Action Group [clickClearFilters2] AdminClearGridFiltersActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersClickClearFilters2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClickClearFilters2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickClearFilters2
		$I->comment("Exiting Action Group [clickClearFilters2] AdminClearGridFiltersActionGroup");
		$I->comment("Entering Action Group [fillTaxIdentifierField3] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->fillField("#tax_rate_grid_filter_code", "Tax Rate " . msq("defaultTaxRate")); // stepKey: fillNameFilterFillTaxIdentifierField3
		$I->comment("Exiting Action Group [fillTaxIdentifierField3] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearch2
		$I->waitForPageLoad(30); // stepKey: clickSearch2WaitForPageLoad
		$I->see("We couldn't find any records.", ".empty-text"); // stepKey: seeSuccess
		$I->comment("Confirm Deleted TaxIdentifier on the tax rule grid page");
		$I->comment("Entering Action Group [goToTaxRuleIndex3] AdminTaxRuleGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRuleGridPageGoToTaxRuleIndex3
		$I->waitForPageLoad(30); // stepKey: waitForTaxRulePageGoToTaxRuleIndex3
		$I->comment("Exiting Action Group [goToTaxRuleIndex3] AdminTaxRuleGridOpenPageActionGroup");
		$I->comment("Entering Action Group [clickAddNewTaxRuleButton] AdminClickAddTaxRuleButtonActionGroup");
		$I->click("#add"); // stepKey: clickAddNewTaxRuleButtonClickAddNewTaxRuleButton
		$I->waitForPageLoad(30); // stepKey: clickAddNewTaxRuleButtonClickAddNewTaxRuleButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTaxRuleGridLoadClickAddNewTaxRuleButton
		$I->comment("Exiting Action Group [clickAddNewTaxRuleButton] AdminClickAddTaxRuleButtonActionGroup");
		$I->fillField("input[data-role='advanced-select-text']", $I->retrieveEntityField('initialTaxRate', 'code', 'test')); // stepKey: fillTaxRateSearch
		$I->wait(5); // stepKey: waitForSearch
		$I->dontSee($I->retrieveEntityField('initialTaxRate', 'code', 'test'), "div.field-tax_rate"); // stepKey: dontSeeInTaxRuleForm
	}
}
