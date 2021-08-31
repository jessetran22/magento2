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
 * @Title("MC-5322: Create tax rate, large rate")
 * @Description("Test log in to Create Tax Rate and Create Large Rate<h3>Test files</h3>app/code/Magento/Tax/Test/Mftf/Test/AdminCreateTaxRateLargeRateTest.xml<br>")
 * @TestCaseId("MC-5322")
 * @group tax
 * @group mtf_migrated
 */
class AdminCreateTaxRateLargeRateTestCest
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
	public function AdminCreateTaxRateLargeRateTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToTaxRateIndex1] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRateIndex1
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRateIndex1
		$I->comment("Exiting Action Group [goToTaxRateIndex1] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Create a tax rate for large postcodes");
		$I->click("#add"); // stepKey: clickAddNewTaxRateButton
		$I->waitForPageLoad(30); // stepKey: clickAddNewTaxRateButtonWaitForPageLoad
		$I->fillField("#code", "TaxRate" . msq("SimpleTaxRate")); // stepKey: fillRuleName
		$I->fillField("#tax_postcode", "*"); // stepKey: fillPostCode
		$I->selectOption("#tax_country_id", "France"); // stepKey: selectCountry1
		$I->selectOption("#tax_region_id", "Val-d'Oise"); // stepKey: selectState
		$I->fillField("#rate", "999"); // stepKey: fillRate
		$I->click("#save"); // stepKey: clickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveWaitForPageLoad
		$I->see("You saved the tax rate.", "#messages div.message-success"); // stepKey: seeSuccess
		$I->comment("Entering Action Group [goToTaxRateIndex2] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRateIndex2
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRateIndex2
		$I->comment("Exiting Action Group [goToTaxRateIndex2] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Create a tax rate for large postcodes and verify we see expected values on the tax rate grid page");
		$I->comment("Entering Action Group [clickClearFilters2] AdminClearGridFiltersActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersClickClearFilters2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClickClearFilters2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickClearFilters2
		$I->comment("Exiting Action Group [clickClearFilters2] AdminClearGridFiltersActionGroup");
		$I->comment("Entering Action Group [fillTaxIdentifierField2] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->fillField("#tax_rate_grid_filter_code", "TaxRate" . msq("SimpleTaxRate")); // stepKey: fillNameFilterFillTaxIdentifierField2
		$I->comment("Exiting Action Group [fillTaxIdentifierField2] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->selectOption("#tax_rate_grid_filter_tax_country_id", "France"); // stepKey: selectCountry2
		$I->fillField("#tax_rate_grid_filter_tax_postcode", "*"); // stepKey: seeTaxPostCode1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearch2
		$I->waitForPageLoad(30); // stepKey: clickSearch2WaitForPageLoad
		$I->click("#tax_rate_grid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRow3
		$I->waitForPageLoad(30); // stepKey: clickFirstRow3WaitForPageLoad
		$I->comment("Verify we see expected values on the tax rate form page");
		$I->seeInField("#code", "TaxRate" . msq("SimpleTaxRate")); // stepKey: seeTaxIdentifierField2
		$I->seeInField("#tax_postcode", "*"); // stepKey: seeZipCode
		$I->seeOptionIsSelected("#tax_country_id", "France"); // stepKey: seeCountry2
		$I->seeOptionIsSelected("#tax_region_id", "Val-d'Oise"); // stepKey: seeState
		$I->seeInField("#rate", "999.0000"); // stepKey: seeRate
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
