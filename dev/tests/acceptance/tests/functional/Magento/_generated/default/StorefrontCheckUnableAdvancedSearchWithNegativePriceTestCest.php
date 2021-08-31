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
 * @Title("[NO TESTCASEID]: Unable negative price use to advanced search")
 * @Description("Check unable negative price use to advanced search by price from and price to<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/StorefrontCheckUnableAdvancedSearchWithNegativePriceTest.xml<br>")
 */
class StorefrontCheckUnableAdvancedSearchWithNegativePriceTestCest
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
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"CatalogSearch"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckUnableAdvancedSearchWithNegativePriceTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToStorefront] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefront
		$I->comment("Exiting Action Group [goToStorefront] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [openAdvancedSearch] StorefrontOpenAdvancedSearchActionGroup");
		$I->click("//footer//ul//li//a[text()='Advanced Search']"); // stepKey: clickAdvancedSearchLinkOpenAdvancedSearch
		$I->seeInCurrentUrl("/catalogsearch/advanced/"); // stepKey: checkUrlOpenAdvancedSearch
		$I->seeInTitle("Advanced Search"); // stepKey: assertAdvancedSearchTitle1OpenAdvancedSearch
		$I->see("Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchTitle2OpenAdvancedSearch
		$I->comment("Exiting Action Group [openAdvancedSearch] StorefrontOpenAdvancedSearchActionGroup");
		$I->comment("Entering Action Group [assertUnableSearch] StorefrontAssertUnableSearchNegativeForPriceFieldActionGroup");
		$I->fillField("#name", ""); // stepKey: fillNameAssertUnableSearch
		$I->fillField("#sku", ""); // stepKey: fillSkuAssertUnableSearch
		$I->fillField("#description", ""); // stepKey: fillDescriptionAssertUnableSearch
		$I->fillField("#short_description", ""); // stepKey: fillShortDescriptionAssertUnableSearch
		$I->fillField("#price", "-10"); // stepKey: fillPriceFromAssertUnableSearch
		$I->fillField("#price_to", "-50"); // stepKey: fillPriceToAssertUnableSearch
		$I->scrollTo("//*[@id='form-validate']//button[@type='submit']"); // stepKey: scrollToSubmitButtonAssertUnableSearch
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitAssertUnableSearch
		$grabPriceFromErrorAssertUnableSearch = $I->grabTextFrom("#price-error"); // stepKey: grabPriceFromErrorAssertUnableSearch
		$grabPriceToErrorAssertUnableSearch = $I->grabTextFrom("#price_to-error"); // stepKey: grabPriceToErrorAssertUnableSearch
		$I->assertEquals("$grabPriceFromErrorAssertUnableSearch", "Please enter a number 0 or greater in this field."); // stepKey: assertErrorMessagePriceFromAssertUnableSearch
		$I->assertEquals("$grabPriceToErrorAssertUnableSearch", "Please enter a number 0 or greater in this field."); // stepKey: assertErrorMessagePriceToAssertUnableSearch
		$I->comment("Exiting Action Group [assertUnableSearch] StorefrontAssertUnableSearchNegativeForPriceFieldActionGroup");
	}
}
