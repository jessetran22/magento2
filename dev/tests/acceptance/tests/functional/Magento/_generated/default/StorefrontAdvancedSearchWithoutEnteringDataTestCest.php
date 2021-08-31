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
 * @Title("MAGETWO-14859: Do Advanced Search without entering data")
 * @Description("'Enter a search term and try again.' error message is missed in Advanced Search<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/StorefrontAdvancedSearchWithoutEnteringDataTest.xml<br>")
 * @TestCaseId("MAGETWO-14859")
 * @group searchFrontend
 * @group mtf_migrated
 */
class StorefrontAdvancedSearchWithoutEnteringDataTestCest
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
	 * @Stories({"Use Advanced Search"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"CatalogSearch"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAdvancedSearchWithoutEnteringDataTest(AcceptanceTester $I)
	{
		$I->comment("1. Navigate to Frontend");
		$I->comment("Entering Action Group [goToStorefront] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefront
		$I->comment("Exiting Action Group [goToStorefront] StorefrontOpenHomePageActionGroup");
		$I->comment("2. Click \"Advanced Search\"");
		$I->comment("Entering Action Group [openAdvancedSearch] StorefrontOpenAdvancedSearchActionGroup");
		$I->click("//footer//ul//li//a[text()='Advanced Search']"); // stepKey: clickAdvancedSearchLinkOpenAdvancedSearch
		$I->seeInCurrentUrl("/catalogsearch/advanced/"); // stepKey: checkUrlOpenAdvancedSearch
		$I->seeInTitle("Advanced Search"); // stepKey: assertAdvancedSearchTitle1OpenAdvancedSearch
		$I->see("Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchTitle2OpenAdvancedSearch
		$I->comment("Exiting Action Group [openAdvancedSearch] StorefrontOpenAdvancedSearchActionGroup");
		$I->comment("3. Fill test data in to field(s) 4. Click \"Search\" button");
		$I->comment("Entering Action Group [search] StorefrontFillFormAdvancedSearchActionGroup");
		$I->fillField("#name", ""); // stepKey: fillNameSearch
		$I->fillField("#sku", ""); // stepKey: fillSkuSearch
		$I->fillField("#description", ""); // stepKey: fillDescriptionSearch
		$I->fillField("#short_description", ""); // stepKey: fillShortDescriptionSearch
		$I->fillField("#price", ""); // stepKey: fillPriceFromSearch
		$I->fillField("#price_to", ""); // stepKey: fillPriceToSearch
		$I->scrollTo("//*[@id='form-validate']//button[@type='submit']"); // stepKey: scrollToSubmitButtonSearch
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearch
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearch
		$I->comment("Exiting Action Group [search] StorefrontFillFormAdvancedSearchActionGroup");
		$I->comment("5. Perform all asserts");
		$I->see("Enter a search term and try again.", "div .message"); // stepKey: see
	}
}
