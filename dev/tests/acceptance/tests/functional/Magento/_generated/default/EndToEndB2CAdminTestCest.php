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
 * @group e2e
 * @Title("MAGETWO-87014: Pass End to End B2C Admin scenario")
 * @Description("Admin creates products, creates and manages categories, creates promotions, creates an order, processes an order, processes a return, uses admin grids<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/EndToEndB2CAdminTest.xml<br>app/code/Magento/Bundle/Test/Mftf/Test/EndToEndB2CAdminTest.xml<br>app/code/Magento/Sales/Test/Mftf/Test/EndToEndB2CAdminTest.xml<br>app/code/Magento/Downloadable/Test/Mftf/Test/EndToEndB2CAdminTest.xml<br>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/EndToEndB2CAdminTest.xml<br>app/code/Magento/GroupedProduct/Test/Mftf/Test/EndToEndB2CAdminTest.xml<br>app/code/Magento/Shipping/Test/Mftf/Test/EndToEndB2CAdminTest.xml<br>")
 * @TestCaseId("MAGETWO-87014")
 */
class EndToEndB2CAdminTestCest
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
	 * @Features({"Catalog"})
	 * @Stories({"B2C admin - MAGETWO-75412"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function EndToEndB2CAdminTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nMQE-891");
	}
}
