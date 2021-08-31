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
 * @Title("MC-5320: Create tax rate, specific postcode")
 * @Description("Test log in to Create Tax Rate and Create specific Postcode<h3>Test files</h3>app/code/Magento/Tax/Test/Mftf/Test/AdminCreateTaxRateSpecificPostcodeTest.xml<br>")
 * @TestCaseId("MC-5320")
 * @group tax
 * @group mtf_migrated
 */
class AdminCreateTaxRateSpecificPostcodeTestCest
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
	public function AdminCreateTaxRateSpecificPostcodeTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToTaxRateIndex1] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRateIndex1
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRateIndex1
		$I->comment("Exiting Action Group [goToTaxRateIndex1] AdminTaxRateGridOpenPageActionGroup");
		$I->click("#add"); // stepKey: clickAddNewTaxRateButton
		$I->waitForPageLoad(30); // stepKey: clickAddNewTaxRateButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTaxRateIndex1
		$I->comment("Create a tax rate with specific postcode");
		$I->fillField("#code", "TaxRate" . msq("SimpleTaxRate")); // stepKey: fillTaxIdentifierField1
		$I->fillField("#tax_postcode", "180"); // stepKey: fillTaxPostCode
		$I->selectOption("#tax_country_id", "Canada"); // stepKey: selectCountry
		$I->selectOption("#tax_region_id", "*"); // stepKey: selectState
		$I->fillField("#rate", "25"); // stepKey: seeRate
		$I->click("#save"); // stepKey: clickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveWaitForPageLoad
		$I->see("You saved the tax rate.", "#messages div.message-success"); // stepKey: seeSuccess
		$I->comment("Entering Action Group [goToTaxRateIndex2] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRateIndex2
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRateIndex2
		$I->comment("Exiting Action Group [goToTaxRateIndex2] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Verify the tax rate grid page shows the specific postcode we just created");
		$I->comment("Entering Action Group [clickClearFilters1] AdminClearGridFiltersActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersClickClearFilters1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClickClearFilters1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickClearFilters1
		$I->comment("Exiting Action Group [clickClearFilters1] AdminClearGridFiltersActionGroup");
		$I->comment("Entering Action Group [fillTaxIdentifierField2] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->fillField("#tax_rate_grid_filter_code", "TaxRate" . msq("SimpleTaxRate")); // stepKey: fillNameFilterFillTaxIdentifierField2
		$I->comment("Exiting Action Group [fillTaxIdentifierField2] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->selectOption("#tax_rate_grid_filter_tax_country_id", "Canada"); // stepKey: fillCountryFilter
		$I->fillField("#tax_rate_grid_filter_tax_postcode", "180"); // stepKey: fillPostCodeFilter
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearch
		$I->waitForPageLoad(30); // stepKey: clickSearchWaitForPageLoad
		$I->click("#tax_rate_grid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRow1
		$I->waitForPageLoad(30); // stepKey: clickFirstRow1WaitForPageLoad
		$I->comment("Verify we see expected values on the tax rate form page");
		$I->seeInField("#code", "TaxRate" . msq("SimpleTaxRate")); // stepKey: seeTaxIdentifierField2
		$I->seeInField("#tax_postcode", "180"); // stepKey: seePostCode
		$I->seeInField("#tax_country_id", "Canada"); // stepKey: seeCountry2
		$I->comment("Verify we see expected values on the tax rule form page");
		$I->comment("Entering Action Group [goToTaxRuleIndex1] AdminTaxRuleGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRuleGridPageGoToTaxRuleIndex1
		$I->waitForPageLoad(30); // stepKey: waitForTaxRulePageGoToTaxRuleIndex1
		$I->comment("Exiting Action Group [goToTaxRuleIndex1] AdminTaxRuleGridOpenPageActionGroup");
		$I->comment("Entering Action Group [clickAdd] AdminClickAddTaxRuleButtonActionGroup");
		$I->click("#add"); // stepKey: clickAddNewTaxRuleButtonClickAdd
		$I->waitForPageLoad(30); // stepKey: clickAddNewTaxRuleButtonClickAddWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTaxRuleGridLoadClickAdd
		$I->comment("Exiting Action Group [clickAdd] AdminClickAddTaxRuleButtonActionGroup");
		$I->see("TaxRate" . msq("SimpleTaxRate"), ".mselect-list-item"); // stepKey: seeTaxRateOnNewTaxRulePage
	}
}
