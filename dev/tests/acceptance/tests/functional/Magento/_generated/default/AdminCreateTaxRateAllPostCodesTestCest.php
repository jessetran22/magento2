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
 * @Title("MC-5318: Create tax rate, all postcodes")
 * @Description("Tests log into Create tax rate and create all postcodes<h3>Test files</h3>app/code/Magento/Tax/Test/Mftf/Test/AdminCreateTaxRateAllPostCodesTest.xml<br>")
 * @TestCaseId("MC-5318")
 * @group tax
 * @group mtf_migrated
 */
class AdminCreateTaxRateAllPostCodesTestCest
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
		$I->comment("Entering Action Group [goToTaxRateIndex] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRateIndex
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRateIndex
		$I->comment("Exiting Action Group [goToTaxRateIndex] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Entering Action Group [clickClearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClickClearFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClickClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clickClearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [filterByCode] AdminFilterTaxRateByCodeActionGroup");
		$I->fillField("#tax_rate_grid_filter_code", "TaxRate" . msq("SimpleTaxRate")); // stepKey: fillNameFilterFilterByCode
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
	 * @Stories({"Create tax rate"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Tax"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateTaxRateAllPostCodesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToTaxRateIndex1] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRateIndex1
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRateIndex1
		$I->comment("Exiting Action Group [goToTaxRateIndex1] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Create a tax rate with * for postcodes");
		$I->click("#add"); // stepKey: clickAddNewTaxRateButton
		$I->waitForPageLoad(30); // stepKey: clickAddNewTaxRateButtonWaitForPageLoad
		$I->fillField("#code", "TaxRate" . msq("SimpleTaxRate")); // stepKey: fillRuleName
		$I->fillField("#tax_postcode", "*"); // stepKey: fillPostCode
		$I->selectOption("#tax_country_id", "Australia"); // stepKey: selectCountry1
		$I->fillField("#rate", "20"); // stepKey: fillRate
		$I->click("#save"); // stepKey: clickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveWaitForPageLoad
		$I->see("You saved the tax rate.", "#messages div.message-success"); // stepKey: seeSuccess
		$I->comment("Verify the tax rate grid page shows the tax rate we just created");
		$I->comment("Entering Action Group [goToTaxRateIndex2] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRateIndex2
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRateIndex2
		$I->comment("Exiting Action Group [goToTaxRateIndex2] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Entering Action Group [clickClearFilters1] AdminClearGridFiltersActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersClickClearFilters1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClickClearFilters1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickClearFilters1
		$I->comment("Exiting Action Group [clickClearFilters1] AdminClearGridFiltersActionGroup");
		$I->comment("Entering Action Group [fillNameFilter] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->fillField("#tax_rate_grid_filter_code", "TaxRate" . msq("SimpleTaxRate")); // stepKey: fillNameFilterFillNameFilter
		$I->comment("Exiting Action Group [fillNameFilter] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->selectOption("#tax_rate_grid_filter_tax_country_id", "Australia"); // stepKey: fillCountryFilter
		$I->fillField("#tax_rate_grid_filter_tax_postcode", "*"); // stepKey: fillPostCodeFilter
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearch
		$I->waitForPageLoad(30); // stepKey: clickSearchWaitForPageLoad
		$I->see("TaxRate" . msq("SimpleTaxRate"), "#tax_rate_grid"); // stepKey: seeRuleName
		$I->see("Australia", "#tax_rate_grid"); // stepKey: seeCountry
		$I->see("*", "#tax_rate_grid"); // stepKey: seePostCode
		$I->comment("Go to the tax rate edit page for our new tax rate");
		$I->comment("Entering Action Group [goToTaxRateIndex3] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRateIndex3
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRateIndex3
		$I->comment("Exiting Action Group [goToTaxRateIndex3] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Entering Action Group [clickClearFilters2] AdminClearGridFiltersActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersClickClearFilters2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClickClearFilters2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickClearFilters2
		$I->comment("Exiting Action Group [clickClearFilters2] AdminClearGridFiltersActionGroup");
		$I->comment("Entering Action Group [fillNameFilter2] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->fillField("#tax_rate_grid_filter_code", "TaxRate" . msq("SimpleTaxRate")); // stepKey: fillNameFilterFillNameFilter2
		$I->comment("Exiting Action Group [fillNameFilter2] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearch2
		$I->waitForPageLoad(30); // stepKey: clickSearch2WaitForPageLoad
		$I->click("#tax_rate_grid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRow
		$I->waitForPageLoad(30); // stepKey: clickFirstRowWaitForPageLoad
		$I->comment("Verify we see expected values on the tax rate edit page");
		$I->seeInField("#code", "TaxRate" . msq("SimpleTaxRate")); // stepKey: seeRuleName2
		$I->seeInField("#tax_postcode", "*"); // stepKey: seeZipCode
		$I->seeOptionIsSelected("#tax_country_id", "Australia"); // stepKey: seeCountry2
		$I->seeInField("#rate", "20.0000"); // stepKey: seeRate
		$I->comment("Go to the tax rule grid page and verify our tax rate can be used in the rule");
		$I->comment("Entering Action Group [goToTaxRuleIndex1] AdminTaxRuleGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRuleGridPageGoToTaxRuleIndex1
		$I->waitForPageLoad(30); // stepKey: waitForTaxRulePageGoToTaxRuleIndex1
		$I->comment("Exiting Action Group [goToTaxRuleIndex1] AdminTaxRuleGridOpenPageActionGroup");
		$I->click("#add"); // stepKey: clickAddNewTaxRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewTaxRuleWaitForPageLoad
		$I->see("TaxRate" . msq("SimpleTaxRate"), ".mselect-list-item"); // stepKey: seeTaxRateOnNewTaxRulePage
	}
}
